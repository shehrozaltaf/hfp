<?php

namespace App\Http\Controllers;


use App\Models\App_Users_Model;
use App\Models\Custom_Model;
use App\Models\Settings_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class App_Users extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = array();
        $data["districts"] = Custom_Model::getDistricts();
        $data["data"] = App_Users_Model::getAllData();
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', 'App_Users');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "App_Users",
            "action" => "View App_Users -> Function: App_Users/index()",
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
            return view('app_users', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }
    }

    public function addAppUsers(Request $request)
    {
        $newPassword = $request->input('userPassword');
        $salt = openssl_random_pseudo_bytes(16);
        $userPasswordenc = Custom_Model::genPassword($newPassword, $salt, 'sha1');

        $array = array();
        $array['full_name'] = $request->input('fullName');
        $array['username'] = $request->input('userName');
        $array['password'] = $request->input('userPassword');
        $array['passwordenc'] = $userPasswordenc;
        $array['pwdExpiry'] = date('Y-m-d', strtotime('+90 days'));
        $array['dist_id'] = $request->input('district');
        $array['uccode'] = $request->input('uc');
        $array['designation'] = $request->input('designation');
        $array['vtype'] = $request->input('vtype');
        $array['enabled'] = 1;
        $array['isNewUser'] = 1;
        $array['colflag'] = 0;
        $array['attempt'] = 0;
        $array['auth_level'] = 0;
        $array['createdBy'] = auth()->id();
        $array['createdDateTime'] = date('Y-m-d H:i:s');
        $checkName = App_Users_Model::checkName($array['username']);
        if (count($checkName) == 0) {
            if (DB::table('users')->insert($array)) {
                $result = array('Success', 'Successfully Inserted', 'success');
            } else {
                $result = array('Error', 'Something went wrong in inserting data', 'danger');
            }
        } else {
            $result = array('Error', 'User Name already exist', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "App_Users",
            "action" => "Add App_Users -> Function: App_Users/addAppUsers()",
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

    public function getUserData(Request $request)
    {
        $id = $request->input('id');
        $getUserData = App_Users_Model::getUserDetails($id);
        return json_encode($getUserData);
    }

    public function editAppUsers(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '') {
            $array['full_name'] = $request->input('fullName');
            $array['dist_id'] = $request->input('district');
            $array['uccode'] = $request->input('uc');
            $array['designation'] = $request->input('designation');
            $array['vtype'] = $request->input('vtype');
            $array['attempt'] = 0;
            $array['updateBy'] = auth()->id();
            $array['updatedDateTime'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('users')
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
            "activityName" => "App_Users",
            "action" => "Edit App_Users -> Function: App_Users/editAppUsers()",
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

    public function resetPwd(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '' && isset($_POST['userPassword']) && $_POST['userPassword'] != '') {
            $newPassword = $request->input('userPassword');
            $salt = openssl_random_pseudo_bytes(16);
            $userPasswordenc = Custom_Model::genPassword($newPassword, $salt, 'sha1');
            $array['password'] = $request->input('userPassword');
            $array['passwordenc'] = $userPasswordenc;
            $array['pwdExpiry'] = date('Y-m-d', strtotime('+90 days'));
            $array['isNewUser'] = 1;
            $array['attempt'] = 0;
            $array['updateBy'] = auth()->id();
            $array['updatedDateTime'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('users')
                ->where('id', $id)
                ->update($array);
            if ($updateQuery) {
                $result = array('Success', 'Successfully Edited', 'success');
            } else {
                $result = array('Error', 'Something went wrong in editing data', 'danger');
            }
        } else {
            $result = array('Error', 'Invalid User', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "App_Users",
            "action" => "Edit App_Users -> Function: App_Users/resetPwd()",
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

    public function deleteAppUsers(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '') {

            $array['colflag'] = 1;
            $array['enabled'] = 0;
            $array['deleteBy'] = auth()->id();
            $array['deletedDateTime'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('users')
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
            "activityName" => "App_Users",
            "action" => "Delete App_Users -> Function: App_Users/deleteAppUsers()",
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
