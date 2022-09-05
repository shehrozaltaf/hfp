<?php

namespace App\Http\Requests\Auth;

use App\Models\Custom_Model;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'recaptcha' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $data = [
            'secret' => config('services.recaptcha.secret'),
            'response' => $this->input('recaptcha'),
            'remoteip' => $remoteip
        ];
        $options = [
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
            ),
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),

            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $resultJson = json_decode($result);
        if ($resultJson->success == true && $resultJson->score >= 0.3) {
            $this->ensureIsNotRateLimited();

            $user = User::where('email', Str::lower($this->input('email')))->first();
            if (isset($user->attempt) && $user->attempt != '') {
                $attempt = $user->attempt;
            } else {
                $attempt = 0;
            }
            $attempt++;

            if ($user->status == 0) {
                $this->lockAccount($attempt);
                $this->loginTrail('Login Failed - User is Deleted', $remoteip, 'Error');
                throw ValidationException::withMessages([
                    'recaptcha' => __('User deleted'),
                ]);
            }

            if ($user->attempt >= 5) {
                $this->lockAccount($attempt);
                $this->loginTrail('Login Failed - User Blocked, please contact admins', $remoteip, 'Error');
                throw ValidationException::withMessages([
                    'recaptcha' => __('User Blocked, please contact admins'),
                ]);
            }
            if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
                RateLimiter::hit($this->throttleKey());

                $this->lockAccount($attempt);
                $this->loginTrail('Login Failed - These credentials do not match our records.', $remoteip, 'Error');

                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            }
            $this->lockAccount(1);
            $this->loginTrail('Login Success', $remoteip, 'Success');
            RateLimiter::clear($this->throttleKey());
        } else {
            $this->loginTrail('Login Failed - Captcha Validation Failed', $remoteip, 'Error');
            throw ValidationException::withMessages([
                'recaptcha' => __('Captcha Validation Failed'),
            ]);
        }

    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => 3,
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('email')) . '|' . $this->ip();
    }

    public function loginTrail($res, $remoteip, $mainResult = '')
    {
        $array = array();
        $array['idUser'] = Str::lower($this->input('email'));
        $array['result'] = $res;
        $array['ip_address'] = $remoteip;
        $array['attempted_at'] = date('Y-m-d H:i:s');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Login",
            "action" => "Login -> Function: Login/Login()",
            "mainResult" => $mainResult,
            "result" => $res,
            "PostData" => $array,
            "affectedKey" => 'id=' . $array['idUser'],
            "idUser" => $array['idUser'],
            "username" => $array['idUser'],
        );
        Custom_Model::trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        return DB::table('user_logins_trails')->insert($array);
    }

    public function lockAccount($attempt)
    {
        $array = array();
        $array['attempt'] = $attempt;
        $array['attemptDateTime'] = date('Y-m-d H:i:s');
        return DB::table('users_dash')
            ->where('email', Str::lower($this->input('email')))
            ->update($array);
    }
}
