<?php

namespace App\Http\Controllers;

use App\Models\Custom_Model;
use App\Models\Health_facility_Model;
use App\Models\Settings_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Health_facility extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = array();
        $data["province"] = Custom_Model::getAllProvinces();
        $data["data"] = Custom_Model::getAllHealth_facility();
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', 'Health_facility');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Health_facility",
            "action" => "View Health_facility -> Function: Health_facility/index()",
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => Auth::user()->id,
            "username" => Auth::user()->username,
        );
        /*==========Log=============*/
        if ($data['permission'][0]->CanView == 1) {
            $trackarray["mainResult"] = "Success";
            $trackarray["result"] = "View Success";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('Health_facility', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }
    }

    public function addHealth_facility(Request $request)
    {
        $array = array();
        $array['distcode'] = $request->input('distcode');
        $array['uccode'] = $request->input('uc');
        $array['hf_name'] = $request->input('hf_name');
        $array['colflag'] = 0;
        $array['createdBy'] = auth()->id();
        $array['createdDateTime'] = date('Y-m-d H:i:s');
        $checkName = Health_facility_Model::checkName($array['hf_name']);
        if (count($checkName) == 0) {

            $getMaxHealth_facilityCode = Health_facility_Model::getMaxHealth_facilityCode($array['uccode']);
            if (isset($getMaxDistrictCode[0]->max_hf_code) && $getMaxDistrictCode[0]->max_hf_code != '') {
                $getMaxHealth_facilityCode = (int)$getMaxDistrictCode[0]->max_hf_code + 1;
            } else {
                $getMaxHealth_facilityCode = $array['uccode'] . '01';
            }

            $array['hf_code'] = (int)$getMaxHealth_facilityCode;
            if (DB::table('hf_list')->insert($array)) {
                $result = array('Success', 'Successfully Inserted', 'success');
            } else {
                $result = array('Error', 'Something went wrong in inserting data', 'danger');
            }
        } else {
            $result = array('Error', 'District Code already exist', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Health_facility",
            "action" => "Add Health_facility -> Function: Health_facility/addHealth_facility()",
            "mainResult" => $result[0],
            "result" => $result[1],
            "PostData" => $array,
            "affectedKey" => 'id',
            "idUser" => Auth::user()->id,
            "username" => Auth::user()->username,
        );
        Custom_Model::trackLogs($trackarray, "all_logs");
        /*==========Log=============*/

        return json_encode($result);
    }

    public function getHealth_facilityData(Request $request)
    {
        $id = $request->input('id');
        $getDistrictData = Health_facility_Model::getHealth_facilityDetails($id);
        return json_encode($getDistrictData);
    }

    public function editHealth_facility(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '') {
            $array['distcode'] = $request->input('distcode');
            $array['uccode'] = $request->input('uc');
            $array['hf_name'] = $request->input('hf_name');
            $array['updateBy'] = auth()->id();
            $array['updatedDateTime'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('hf_list')
                ->where('id', $id)
                ->update($array);
            if ($updateQuery) {
                $result = array('Success', 'Successfully Edited', 'success');
            } else {
                $result = array('Error', 'Something went wrong in editing data', 'danger');
            }
        } else {
            $result = array('Error', 'Invalid User Id', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Health_facility",
            "action" => "Edit Health_facility -> Function: Health_facility/editHealth_facility()",
            "mainResult" => $result[0],
            "result" => $result[1],
            "PostData" => $array,
            "affectedKey" => 'id=' . $id,
            "idUser" => Auth::user()->id,
            "username" => Auth::user()->username,
        );
        Custom_Model::trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        return json_encode($result);
    }


    public function deleteHealth_facility(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '') {
            $array['colflag'] = 1;
            $array['deleteBy'] = auth()->id();
            $array['deletedDateTime'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('hf_list')
                ->where('id', $id)
                ->update($array);
            if ($updateQuery) {
                $result = array('Success', 'Successfully Deleted', 'success');
            } else {
                $result = array('Error', 'Something went wrong in deleting data', 'danger');
            }
        } else {
            $result = array('Error', 'Invalid User Id', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Health_facility",
            "action" => "Delete Health_facility -> Function: Health_facility/deleteHealth_facility()",
            "mainResult" => $result[0],
            "result" => $result[1],
            "PostData" => $array,
            "affectedKey" => 'id=' . $id,
            "idUser" => Auth::user()->id,
            "username" => Auth::user()->username,
        );
        Custom_Model::trackLogs($trackarray, "all_logs");
        /*==========Log=============*/

        return json_encode($result);
    }
}
