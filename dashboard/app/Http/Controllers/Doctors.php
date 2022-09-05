<?php

namespace App\Http\Controllers;

use App\Models\Custom_Model;
use App\Models\Doctors_Model;
use App\Models\Settings_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Doctors extends Controller
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
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', 'doctors');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Doctors",
            "action" => "View Doctors -> Function: Doctors/index()",
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


            $searchFilter = array();
            $searchFilter['province'] = $data['province_slug'];
            $searchFilter['dist'] = $data['district_slug'];
            $searchFilter['uc'] = $data['uc_slug'];
            $data["getData"] = Doctors_Model::getData($searchFilter);

            $trackarray["mainResult"] = "Success";
            $trackarray["result"] = "View Success";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('doctors', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }
    }

    public function addDoctor(Request $request)
    {
        $array = array();
        $array['dist_id'] = $request->input('distcode');
        $array['ucCode'] = $request->input('uc');
        $array['staff_name'] = $request->input('staff_name');
        $array['staff_type'] = $request->input('staff_type');
        $array['colflag'] = 0;
        $array['createdBy'] = auth()->id();
        $array['createdDateTime'] = date('Y-m-d H:i:s');
        $checkName = Doctors_Model::checkName($array['staff_name']);
        if (count($checkName) == 0) {
            if (DB::table('doctorlist')->insert($array)) {
                $result = array('Success', 'Successfully Inserted', 'success');
            } else {
                $result = array('Error', 'Something went wrong in inserting data', 'danger');
            }
        } else {
            $result = array('Error', 'Doctor already exist', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Doctor",
            "action" => "Add Doctor -> Function: Doctor/addDoctor()",
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

    public function getDoctorData(Request $request)
    {
        $id = $request->input('id');
        $getDistrictData = Doctors_Model::getDoctorDetails($id);
        return json_encode($getDistrictData);
    }

    public function editDoctor(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '') {
            $array['dist_id'] = $request->input('distcode');
            $array['ucCode'] = $request->input('uc');
            $array['staff_name'] = $request->input('staff_name');
            $array['staff_type'] = $request->input('staff_type');
            $array['updateBy'] = auth()->id();
            $array['updatedDateTime'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('doctorlist')
                ->where('idDoctor', $id)
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
            "activityName" => "Doctors",
            "action" => "Edit Doctor -> Function: Doctors/editDoctor()",
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

    public function deleteDoctor(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '') {
            $array['colflag'] = 1;
            $array['deleteBy'] = auth()->id();
            $array['deletedDateTime'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('doctorlist')
                ->where('idDoctor', $id)
                ->update($array);
            if ($updateQuery) {
                $result = array('Success', 'Successfully Deleted', 'success');
            } else {
                $result = array('Error', 'Something went wrong in deleting data', 'danger');
            }
        } else {
            $result = array('Error', 'Invalid Doctor Id', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Doctors",
            "action" => "Delete Doctors -> Function: Doctors/deleteDoctor()",
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
