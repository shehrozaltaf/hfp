<?php

namespace App\Http\Controllers;

use App\Models\App_Users_Model;
use App\Models\Custom_Model;
use App\Models\Settings_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Apps extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index()
    {
//        dd(Auth::user()->isNewUser);
        /*  $message = 'This is a log message';
           Log::emergency($message, ['id' => Auth::user()->id]);
              Log::error($message);
             Log::alert($message);
             Log::critical($message);
             Log::warning($message);
             Log::notice($message);
             Log::info($message);
             Log::debug($message);*/
        $data = array();
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', 'Apps');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Apps",
            "action" => "View Apps -> Function: Apps/index()",
            "PostData" => "",
            "affectedKey" => "",
            "idUser" =>Auth::user()->id,
            "username" => Auth::user()->username,
        );
        /*==========Log=============*/

        if ($data['permission'][0]->CanView == 1) {
            $trackarray["mainResult"] = "Success";
            $trackarray["result"]="View Success";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('apps', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"]="View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }

    }
}
