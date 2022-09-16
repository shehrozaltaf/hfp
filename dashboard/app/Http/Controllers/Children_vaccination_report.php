<?php

namespace App\Http\Controllers;

use App\Models\Custom_Model;
use App\Models\Settings_Model;
use App\Models\Children_vaccination_report_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Children_vaccination_report extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = array();
        $data["province"] = Custom_Model::getAllProvinces();
        $data["districts"] = Custom_Model::getAllDistricts();
        $data["ucs"] = Custom_Model::getAllUc();
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', 'children_vaccination_report');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Children_vaccination_report",
            "action" => "View Children_vaccination_report -> Function: Children_vaccination_report/index()",
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => Auth::user()->id,
            "username" => Auth::user()->username,
        );
        /*==========Log=============*/
        if ($data['permission'][0]->CanView == 1) {
            $data['province_slug'] = (isset($_GET['p']) && $_GET['p'] != '' ? $_GET['p'] : 0);
            $data['district_slug'] = (isset($_GET['d']) && $_GET['d'] != '' ? $_GET['d'] : 0);
            $data['uc_slug'] = (isset($_GET['u']) && $_GET['u'] != '' ? $_GET['u'] : 0);

            $data['from_slug'] = (isset($_GET['from']) && $_GET['from'] != '' ? date('Y-m-d', strtotime($_GET['from'])) : 0);
            if (isset($data['from_slug']) && $data['from_slug'] != '' && $data['from_slug'] != 0 && $data['from_slug'] != '1970-01-01') {
                $exp_from = explode('-', $data['from_slug']);
                $data['from_year'] = $exp_from[0];
                $data['from_month'] = $exp_from[1];
                $data['from_day'] = $exp_from[2];
            } else {
                $data['from_year'] = 2022;
                $data['from_month'] = 7;
                $data['from_day'] = 1;
            }

            $data['to_slug'] = (isset($_GET['to']) && $_GET['to'] != '' ? date('Y-m-d', strtotime($_GET['to'])) : 0);
            if (isset($data['to_slug']) && $data['to_slug'] != '' && $data['to_slug'] != 0 && $data['to_slug'] != '1970-01-01') {
                $exp_to = explode('-', $data['to_slug']);
                $data['to_year'] = $exp_to[0];
                $data['to_month'] = $exp_to[1];
                $data['to_day'] = $exp_to[2];
            } else {
                $data['to_year'] = date('Y');
                $data['to_month'] = date('m');
                $data['to_day'] = date('d');
            }

            $searchFilter = array();
            $searchFilter['province'] = $data['province_slug'];
            $searchFilter['dist'] = $data['district_slug'];
            $searchFilter['uc'] = $data['uc_slug'];
            $searchFilter['from_slug'] = $data['from_slug'];
            $searchFilter['to_slug'] = $data['to_slug'];
            $data["getData"] = Children_vaccination_report_Model::getData($searchFilter);

            $trackarray["mainResult"] = "Success";
            $trackarray["result"] = "View Success";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('children_vaccination_report', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }
    }
}
