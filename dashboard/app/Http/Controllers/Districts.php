<?php

namespace App\Http\Controllers;

use App\Models\AD\Health_Care_Providers_Model;
use App\Models\Custom_Model;
use App\Models\Districts_Model;
use App\Models\Settings_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Districts extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = array();
        $data["province"] = Custom_Model::getAllProvinces();
        $data["data"] = Custom_Model::getAllDistricts();
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', 'Districts');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Districts",
            "action" => "View Districts -> Function: Districts/index()",
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
            return view('districts', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }
    }

    public function addDistricts(Request $request)
    {
        $array = array();
        $array['provcode'] = $request->input('provcode');
        $array['provname'] = $request->input('provname');
        $array['distname'] = $request->input('distname');
        $array['colflag'] = 0;
        $array['createdBy'] = auth()->id();
        $array['createdDateTime'] = date('Y-m-d H:i:s');
        $checkName = Districts_Model::checkName($array['distname']);
        if (count($checkName) == 0) {

            $getMaxDistrictCode = Districts_Model::getMaxDistrictCode($array['provcode']);
            if (isset($getMaxDistrictCode[0]->max_dist_code) && $getMaxDistrictCode[0]->max_dist_code != '') {
                $maxDistrictCode = (int)$getMaxDistrictCode[0]->max_dist_code + 1;
            } else {
                $maxDistrictCode = $array['provcode'] . '01';
            }

            $array['distcode'] = (int)$maxDistrictCode;
            if (DB::table('districts')->insert($array)) {
                $result = array('Success', 'Successfully Inserted', 'success');
            } else {
                $result = array('Error', 'Something went wrong in inserting data', 'danger');
            }
        } else {
            $result = array('Error', 'District Code already exist', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Districts",
            "action" => "Add Districts -> Function: Districts/addDistricts()",
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

    public function getDistrictsData(Request $request)
    {
        $id = $request->input('id');
        $getDistrictData = Districts_Model::getDistrictDetails($id);
        return json_encode($getDistrictData);
    }

    public function editDistricts(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '') {
            $array['provcode'] = $request->input('provcode');
            $array['provname'] = $request->input('provname');
            $array['distname'] = $request->input('distname');
            $array['updateBy'] = auth()->id();
            $array['updatedDateTime'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('districts')
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
            "activityName" => "Districts",
            "action" => "Edit Districts -> Function: Districts/editDistricts()",
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

    public function deleteDistricts(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '') {
            $array['colflag'] = 1;
            $array['deleteBy'] = auth()->id();
            $array['deletedDateTime'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('districts')
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
            "activityName" => "Districts",
            "action" => "Delete Districts -> Function: Districts/deleteDistricts()",
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

    public function changeProvince(Request $request)
    {
        $id = $request->input('province');
        $getData = Districts_Model::getDistrictByProvince($id);
        return json_encode($getData);
    }

    public function changeDistrict(Request $request)
    {
        $id = $request->input('district');
        $getData = Districts_Model::getUcByDistrict($id);
        return json_encode($getData);
    }
}
