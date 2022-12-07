<?php

namespace App\Http\Controllers;

use App\Models\Custom_Model;
use App\Models\Dashboard_Model;
use App\Models\Diagnosis_report_Model;
use App\Models\Settings_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = array();

        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', 'dashboard');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Dashboard",
            "action" => "View Dashboard -> Function: Dashboard/index()",
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => (isset(Auth::user()->id) && Auth::user()->id!=''?Auth::user()->id:0),
            "username" => (isset(Auth::user()->username) && Auth::user()->username!=''?Auth::user()->username:0),
        );
        $trackarray["mainResult"] = "Success";
        $trackarray["result"] = "View Success";
        Custom_Model::trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        if ($data['permission'][0]->CanView == 1) {
            $searchFilter=array();
            $data["getTotalPatient"] = Dashboard_Model::getTotalPatient($searchFilter);


            $trackarray["mainResult"] = "Success";
            $trackarray["result"] = "View Success";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('dashboard.index', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }
    }
}
