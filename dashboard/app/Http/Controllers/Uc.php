<?php

namespace App\Http\Controllers;

use App\Models\Custom_Model;
use App\Models\Uc_Model;
use App\Models\Settings_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Uc extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = array();
        $data["province"] = Custom_Model::getAllProvinces();
        $data["data"] = Custom_Model::getAllUc();
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', 'Uc');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Uc",
            "action" => "View Uc -> Function: Uc/index()",
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
            return view('Uc', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }
    }

    public function addUc(Request $request)
    {
        $array = array();
        $array['provcode'] = $request->input('provcode');
        $array['provname'] = $request->input('provname');
        $array['distcode'] = $request->input('distcode');
        $array['distname'] = $request->input('distname');
        $array['ucname'] = $request->input('ucname');
        $array['colflag'] = 0;
        $array['createdBy'] = auth()->id();
        $array['createdDateTime'] = date('Y-m-d H:i:s');
        $checkName = Uc_Model::checkName($array['ucname']);
        if (count($checkName) == 0) {
            $getMaxUcCode = Uc_Model::getMaxUcCode($array['distcode']);
            if (isset($getMaxUcCode[0]->max_uc_code) && $getMaxUcCode[0]->max_uc_code != '') {
                $maxUcCode = (int)$getMaxUcCode[0]->max_uc_code + 1;
            } else {
                $maxUcCode = $array['distcode'] . '001';
            }

            $array['uccode'] = (int)$maxUcCode;
            if (DB::table('uclist')->insert($array)) {
                $result = array('Success', 'Successfully Inserted', 'success');
            } else {
                $result = array('Error', 'Something went wrong in inserting data', 'danger');
            }
        } else {
            $result = array('Error', 'District Code already exist', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Uc",
            "action" => "Add Uc -> Function: Uc/addUc()",
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

    public function getUcData(Request $request)
    {
        $id = $request->input('id');
        $getUcDetails = Uc_Model::getUcDetails($id);
        return json_encode($getUcDetails);
    }

    public function editUc(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '') {
            $array['provcode'] = $request->input('provcode');
            $array['provname'] = $request->input('provname');
            $array['distcode'] = $request->input('distcode');
            $array['distname'] = $request->input('distname');
            $array['ucname'] = $request->input('ucname');
            $array['updateBy'] = auth()->id();
            $array['updatedDateTime'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('uclist')
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
            "activityName" => "Uc",
            "action" => "Edit Uc -> Function: Uc/editUc()",
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


    public function deleteUc(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '') {
            $array['colflag'] = 1;
            $array['deleteBy'] = auth()->id();
            $array['deletedDateTime'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('uclist')
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
            "activityName" => "Uc",
            "action" => "Delete Uc -> Function: Uc/deleteUc()",
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
