<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users_dash';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'idGroup',
        'district',
        'contact',
        'designation',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*Users*/
    public static function getAllDashboardUsers($status = '')
    {
        $sql = DB::table('users_dash')->select('users_dash.id',
            'users_dash.name',
            'users_dash.email',
            'users_dash.username',
            'users_dash.designation',
            'users_dash.contact',
            'users_dash.district',
            'group.groupName')
            ->leftJoin('group', 'users_dash.idGroup', '=', 'group.idGroup');
        if (!isset($status) || $status != '') {
            $sql->where('users_dash.status', '=', '1');
        }
        $sql->where('group.isActive', '=', '1');
        $sql->orderBy('users_dash.id', 'DESC');
        $data = $sql->get();
        return $data;
    }

    public static function checkDashUserName($userName, $email)
    {
        $sql = DB::table('users_dash')->select('*');
        $sql->where('status', '=', '1');
        $sql->where('username', '=', $userName);
        $sql->orWhere('email', '=', $email);
        $data = $sql->get();
        return $data;
    }

    public static function getDashUserDetails($id)
    {
        $data = DB::table('users_dash')
            ->where('id', $id)
            ->get();
        return $data;
    }

    public static function getUserActivity($user)
    {
        $sql = DB::table('users_dash_activity')->select('users_dash_activity.idUserActivity',
            'users_dash_activity.idUser',
            'users_dash_activity.activityName',
            'users_dash_activity.actiontype',
            'users_dash_activity.result',
            'users_dash_activity.postData',
            'users_dash_activity.affectedKey',
            'users_dash_activity.isActive',
            'users_dash.name',
            'users_dash.username',
            'users_dash_activity.createdBy',
            'users_dash_activity.createdDateTime',
            'users_dash.createdBy',
            'users_dash.created_at',
            'users_dash.updateBy',
            'users_dash.updated_at',
            'users_dash.deleteBy',
            'users_dash.deletedDateTime',
            'users_dash.status')
            ->leftJoin('users_dash', function ($join) {
                $join->on('users_dash_activity.idUser', '=', 'users_dash.username');
                $join->orOn('users_dash_activity.idUser', '=', 'users_dash.email');
            })
            ->where('isActive', 1);
        if (isset($user) && $user != '' && $user != 0) {
            $sql->where(function ($query) use ($user) {
                $query->where('users_dash.id', '=', $user)
                    ->orWhere('users_dash.username', '=', $user)
                    ->orWhere('users_dash.email', 'like', '%'.$user.'%');
            });
        }
        $sql->orderBy('users_dash_activity.idUserActivity', 'DESC');
        $data = $sql->get();
        return $data;
    }

    public static function getUserLoginActivity($user)
    {
        $sql = DB::table('user_logins_trails')->select('user_logins_trails.id',
            'user_logins_trails.idUser',
            'user_logins_trails.ip_address',
            'user_logins_trails.attempted_at',
            'user_logins_trails.result',
            'users_dash.id',
            'users_dash.username',
            'users_dash.email',
            'users_dash.name')
            ->leftJoin('users_dash', function ($join) {
                $join->on('user_logins_trails.idUser', '=', 'users_dash.username');
                $join->orOn('user_logins_trails.idUser', '=', 'users_dash.email');
            });
        if (isset($user) && $user != '' && $user != 0) {
            $sql->where(function ($query) use ($user) {
                $query->where('users_dash.id', '=', $user)
                    ->orWhere('users_dash.username', '=', $user)
                    ->orWhere('users_dash.email', 'like', '%'.$user.'%');
            });
        }
        $sql->orderBy('user_logins_trails.attempted_at', 'DESC');
        $data = $sql->get();
        return $data;

    }

    public static function getUserLog($user)
    {

        $sql = DB::table('users_dash')->selectRaw('users_dash.id,
	users_dash.name,
	users_dash.username,
	[group].groupName,
	users_dash.status,
	(select ud.username from users_dash ud where ud.id=users_dash.createdBy) as createdBy,
	CAST(users_dash.created_at as datetime) as created_at,
	(select ud.username from users_dash ud where ud.id=users_dash.updateBy) as updateBy,
	CAST(users_dash.updated_at as datetime) as updated_at,
	(select ud.username from users_dash ud where ud.id=users_dash.deleteBy) as deleteBy,
	CAST(users_dash.deletedDateTime as datetime) as deletedDateTime'  )
            ->leftJoin('group', 'users_dash.idGroup', '=', 'group.idGroup');
        if (!isset($user) || $user != '') {
            $sql->where(function ($query) use ($user) {
                $query->where('users_dash.id', '=', $user)
                    ->orWhere('users_dash.username', '=', $user)
                    ->orWhere('users_dash.email', 'like', '%'.$user.'%');
            });
        }
        $sql->where('group.isActive', '=', '1');
        $data = $sql->get();
        return $data;

    }

    public static function getLastLogin($user)
    {

        $sql = DB::table('users_dash_activity')->select('*');
        if (!isset($user) || $user != '') {
            $sql->where(function ($query) use ($user) {
                $query->where('users_dash_activity.createdBy', '=', $user)
                    ->orWhere('users_dash_activity.createdBy', '=', $user)
                    ->orWhere('users_dash_activity.createdBy', 'like', '%'.$user.'%');
            });
        }
        $sql->where('activityName', '=', 'Login');
        $sql->where('result', 'like', '%Login success%');
        $sql->orderBy('idUserActivity', 'DESC');
        $data = $sql->get();
        return $data;
    }
}
