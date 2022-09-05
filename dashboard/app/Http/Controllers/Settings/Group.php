<?php

namespace App\Http\Controllers\Settings;


use App\Http\Controllers\Controller;
use App\Models\Custom_Model;
use App\Models\Settings_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Group extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = array();
        $data["data"] = Settings_Model::getAllGroups();
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', 'groups');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Group",
            "action" => "View Group -> Function: Group/index()",
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
            return view('general_settings.groups', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }

    }

    public function addGroup(Request $request)
    {

        $array = array();
        $array['groupName'] = ucfirst($request->input('groupName'));
        $array['isActive'] = 1;
        $array['createdBy'] = auth()->id();
        $array['createdDateTime'] = date('Y-m-d H:i:s');
        $checkGroupName = Settings_Model::checkGroupName($array['groupName']);
        if (count($checkGroupName) == 0) {
            $insertData = DB::table('group')->insertGetId($array);
            if ($insertData) {
                $pages = Settings_Model::getAllPages();
                foreach ($pages as $p) {
                    $pagegroupArray = array();
                    $pagegroupArray['idGroup'] = $insertData;
                    $pagegroupArray['idPages'] = $p->idPages;
                    $pagegroupArray['CanAdd'] = 0;
                    $pagegroupArray['CanEdit'] = 0;
                    $pagegroupArray['CanDelete'] = 0;
                    $pagegroupArray['CanView'] = 0;
                    $pagegroupArray['CanViewAllDetail'] = 0;
                    $pagegroupArray['isActive'] = 1;
                    DB::table('pagegroup')->insert($pagegroupArray);
                }
                $result = array('Success', 'Successfully Inserted', 'success');
            } else {
                $result = array('Error', 'Something went wrong in inserting data', 'danger');
            }
        } else {
            $result = array('Error', 'Group Name already exist', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Group",
            "action" => "Add Group -> Function: Group/addGroup()",
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

    public function getGroupData(Request $request)
    {
        $id = $request->input('id');
        $getGroupData = Settings_Model::getGroupDetails($id);
        return json_encode($getGroupData);
    }

    public function editGroup(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '') {
            $array['groupName'] = ucfirst($request->input('groupName'));
            $array['updateBy'] = auth()->id();
            $array['updatedDateTime'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('group')
                ->where('idGroup', $id)
                ->update($array);
            if ($updateQuery) {
                $result = array('Success', 'Successfully Edited', 'success');
            } else {
                $result = array('Error', 'Something went wrong in editing data', 'danger');
            }
        } else {
            $result = array('Error', 'Invalid Group Id', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Group",
            "action" => "Edit Group -> Function: Group/editGroup()",
            "mainResult" => $result[0],
            "result" => $result[1],
            "PostData" => $array,
            "affectedKey" => 'idGroup=' . (isset($id) && $id != '' ? $id : ''),
            "idUser" => Auth::user()->id,
            "username" => Auth::user()->username,
        );
        Custom_Model::trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        return json_encode($result);
    }

    public function deleteGroup(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '') {

            $array['isActive'] = 0;
            $array['deleteBy'] = auth()->id();
            $array['deletedDateTime'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('group')
                ->where('idGroup', $id)
                ->update($array);
            if ($updateQuery) {
                $result = array('Success', 'Successfully Deleted', 'success');
            } else {
                $result = array('Error', 'Something went wrong in deleting data', 'danger');
            }
        } else {
            $result = array('Error', 'Invalid Group Id', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Group",
            "action" => "Delete Group -> Function: Group/deleteGroup()",
            "mainResult" => $result[0],
            "result" => $result[1],
            "PostData" => $array,
            "affectedKey" => 'idGroup=' . (isset($id) && $id != '' ? $id : ''),
            "idUser" => Auth::user()->id,
            "username" => Auth::user()->username,
        );
        Custom_Model::trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        return json_encode($result);
    }

}
