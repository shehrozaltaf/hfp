<?php

namespace App\Http\Controllers;

use App\Models\Complaints_Model;
use App\Models\Custom_Model;
use App\Models\Settings_Model;
use Illuminate\Support\Facades\Auth;

class Complaints extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = array();

        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', 'complaints');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Complaints",
            "action" => "View Complaints -> Function: Complaints/index()",
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => (isset(Auth::user()->id) && Auth::user()->id != '' ? Auth::user()->id : 0),
            "username" => (isset(Auth::user()->username) && Auth::user()->username != '' ? Auth::user()->username : 0),
        );
        $trackarray["mainResult"] = "Success";
        $trackarray["result"] = "View Success";
        Custom_Model::trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        if ($data['permission'][0]->CanView == 1) {
            $trackarray["mainResult"] = "Success";
            $trackarray["result"] = "View Success";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('complaints', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }
    }

    function getTopComplaint()
    {
        $searchFilter = array();
        $searchFilter['distname'] = (isset($_GET['id']) && $_GET['id']!=''?$_GET['id']:'Lahore');
        $searchFilter['graph'] = (isset($_GET['graph']) && $_GET['graph']!= '' ? $_GET['graph'] : 'u5');
        $getData = Complaints_Model::getData($searchFilter);
        $data = array();
        $total = 0;
        foreach ($getData as $k => $v) {
            foreach ($v as $kk => $vv) {
                if ($kk != 'distname') {
                    $data[$v->distname][$kk] = $v->$kk;
                    $total += $v->$kk;
                }
            }
            arsort($data[$v->distname]);
        }

        $mydata = array();
        $f = 0;
        foreach ($data[$searchFilter['distname']] as $k => $v) {
            if ($f < 10) {
                $mydata[$f]['x'] = ucfirst(str_replace('_', ' ', $k));
                $mydata[$f]['y'] = number_format(($v / $total) * 100, 2);
                $f++;
            }
        }

        echo json_encode($mydata);

    }
}
