<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\App_Users_Model;
use App\Models\Custom_Model;
use App\Models\Settings_Model;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class Dashboard_Users extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = array();
        $data["data"] = User::getAllDashboardUsers('0');
        $data["districts"] = Custom_Model::getDistricts();
        $data["groups"] = Settings_Model::getAllGroups();
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', 'Dashboard_Users');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Dashboard_Users",
            "action" => "View Dashboard_Users -> Function: Dashboard_Users/index()",
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
            return view('general_settings.dashboard_users', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }

    }

    public function addDashboardUsers(Request $request)
    {
        $array = array();
        $array['name'] = $request->input('fullName');
        $array['username'] = $request->input('userName');
        $array['email'] = $request->input('userEmail');
        $array['password'] = Hash::make($request->userPassword);
        $d = $request->input('district');
        $district = '';
        if (isset($d) && $d != '') {
            foreach ($d as $key => $value) {
                if ($key == 0) {
                    $district .= $value;
                } else {
                    $district .= ', ' . $value;
                }
            }
        }
        $array['district'] = $district;
        $array['contact'] = $request->input('contactNo');
        $array['idGroup'] = $request->input('userGroup');
        $array['designation'] = $request->input('designation');
        $array['status'] = 1;
        $array['isNewUser'] = 1;
        $array['attempt'] = 0;
        $array['pwdExpiry'] = date('Y-m-d', strtotime('+90 days'));

        $array['createdBy'] = auth()->id();
        $array['created_at'] = date('Y-m-d H:i:s');
        $checkName = User::checkDashUserName($array['username'], $array['email']);
        if (count($checkName) == 0) {
            if (DB::table('users_dash')->insert($array)) {
                $result = array('Success', 'Successfully Inserted', 'success');
            } else {
                $result = array('Error', 'Something went wrong in inserting data', 'danger');
            }
        } else {
            $result = array('Error', 'User Name or Email already exist', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Dashboard_Users",
            "action" => "Add Dashboard_Users -> Function: Dashboard_Users/addDashboardUsers()",
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

    public function getDashboardUsersData(Request $request)
    {
        $id = $request->input('id');
        $getUserData = User::getDashUserDetails($id);
        return json_encode($getUserData);
    }

    public function editDashboardUsers(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '') {

            $array['name'] = $request->input('fullName');
//            $array['password'] = Hash::make($request->userPassword);
//            $array['isNewUser'] = 1;
//            $array['pwdExpiry'] = date('Y-m-d', strtotime('+90 days'));
            $d = $request->input('district');
            $district = '';
            if (isset($d) && $d != '') {
                foreach ($d as $key => $value) {
                    if ($key == 0) {
                        $district .= $value;
                    } else {
                        $district .= ', ' . $value;
                    }
                }
            }
            $array['district'] = $district;
            $array['contact'] = $request->input('contactNo');
            $array['idGroup'] = $request->input('userGroup');
            $array['designation'] = $request->input('designation');
            $array['attempt'] = 0;
            $array['updateBy'] = auth()->id();
            $array['updated_at'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('users_dash')
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
            "activityName" => "Dashboard_Users",
            "action" => "Edit Dashboard_Users -> Function: Dashboard_Users/editDashboardUsers()",
            "mainResult" => $result[0],
            "result" => $result[1],
            "PostData" => $array,
            "affectedKey" => 'id=' . (isset($id) && $id != '' ? $id : ''),
            "idUser" => Auth::user()->id,
            "username" => Auth::user()->username,
        );
        Custom_Model::trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        return json_encode($result);
    }

    public function deleteDashboardUsers(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '') {

            $array['status'] = 0;
            $array['deleteBy'] = auth()->id();
            $array['deletedDateTime'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('users_dash')
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
            "activityName" => "Dashboard_Users",
            "action" => "Delete Dashboard_Users -> Function: Dashboard_Users/deleteDashboardUsers()",
            "mainResult" => $result[0],
            "result" => $result[1],
            "PostData" => $array,
            "affectedKey" => 'id=' . (isset($id) && $id != '' ? $id : ''),
            "idUser" => Auth::user()->id,
            "username" => Auth::user()->username,
        );
        Custom_Model::trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        return json_encode($result);
    }

    public function changePassword(Request $request)
    {
        $password = $request->input('newpassword');
        $passwordconfirm = $request->input('newpasswordconfirm');
        $id = auth()->id();
        $array = array();
        if (strlen($password) < 8) {
            $result = array('Error', 'Password length must be greater than 8 digits', 'danger');
            return json_encode($result);
        }
        if (!isset($passwordconfirm) || $passwordconfirm == '' || $password != $passwordconfirm) {
            $result = array('Error', 'Invalid Confirm Password', 'danger');
            return json_encode($result);
        }
        if (isset($password) && $password != '') {
            $getUserData = User::getDashUserDetails($id);
            if (isset($getUserData[0]->password) && password_verify($password, $getUserData[0]->password)) {
                $result = array('Error', 'Password must not be an old password', 'danger');
            } else {
                $array['password'] = Hash::make($password);
                $array['isNewUser'] = 0;
                $array['attempt'] = 0;
                $array['pwdExpiry'] = date('Y-m-d', strtotime('+90 days'));
                $array['lastPwdChangeBy'] = auth()->id();
                $array['lastPwd_dt'] = date('Y-m-d H:i:s');
                $updateQuery = DB::table('users_dash')
                    ->where('id', $id)
                    ->update($array);
                if ($updateQuery) {
                    $result = array('Success', 'Successfully Saved', 'success');
//                $isNewUser = $request->input('isNewUser');
                    /*==========Log=============*/
                    $trackarray = array(
                        "activityName" => "Dashboard_Users Change Password",
                        "action" => "Edit Dashboard_Users Change Password -> Function: Dashboard_Users/changePassword()",
                        "mainResult" => $result[0],
                        "result" => $result[1],
                        "PostData" => $array,
                        "affectedKey" => 'id=' . (isset($id) && $id != '' ? $id : ''),
                        "idUser" => Auth::user()->id,
                        "username" => Auth::user()->username,
                    );
                    Custom_Model::trackLogs($trackarray, "all_logs");
                    /*==========Log=============*/
                } else {
                    $result = array('Error', 'Something went wrong in saving data', 'danger');
                }
            }

        } else {
            $result = array('Error', 'Invalid Password', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Dashboard_Users Change Password",
            "action" => "Edit Dashboard_Users Change Password -> Function: Dashboard_Users/changePassword()",
            "mainResult" => $result[0],
            "result" => $result[1],
            "PostData" => $array,
            "affectedKey" => 'id=' . (isset($id) && $id != '' ? $id : ''),
            "idUser" => Auth::user()->id,
            "username" => Auth::user()->username,
        );
        Custom_Model::trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        return json_encode($result);
    }

    public function resetPwd(Request $request)
    {
        $password = $request->input('userPassword');
        $passwordconfirm = $request->input('userPasswordConfirm');
        $id = $request->input('idUser');
        $array = array();
        if (!isset($id) || $id == '' || $id == 0) {
            $result = array('Error', 'Invalid User', 'danger');
            return json_encode($result);
        }
        if (strlen($password) < 8) {
            $result = array('Error', 'Password length must be greater than 8 digits', 'danger');
            return json_encode($result);
        }
        if (!isset($passwordconfirm) || $passwordconfirm == '' || $password != $passwordconfirm) {
            $result = array('Error', 'Invalid Confirm Password', 'danger');
            return json_encode($result);
        }
        if (isset($password) && $password != '') {
            $array['password'] = Hash::make($password);
            $array['isNewUser'] = 1;
            $array['attempt'] = 0;
            $array['pwdExpiry'] = date('Y-m-d', strtotime('+90 days'));
            $array['lastPwdChangeBy'] = auth()->id();
            $array['lastPwd_dt'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('users_dash')
                ->where('id', $id)
                ->update($array);
            if ($updateQuery) {
                $result = array('Success', 'Successfully Saved', 'success');
//                $isNewUser = $request->input('isNewUser');
                /*==========Log=============*/
                $trackarray = array(
                    "activityName" => "Dashboard_Users Reset Password",
                    "action" => "Edit Dashboard_Users Reset User Password -> Function: Dashboard_Users/resetPwd()",
                    "mainResult" => $result[0],
                    "result" => $result[1],
                    "PostData" => $array,
                    "affectedKey" => 'id=' . (isset($id) && $id != '' ? $id : ''),
                    "idUser" => Auth::user()->id,
                    "username" => Auth::user()->username,
                );
                Custom_Model::trackLogs($trackarray, "all_logs");
                /*==========Log=============*/
            } else {
                $result = array('Error', 'Something went wrong in saving data', 'danger');
            }
        } else {
            $result = array('Error', 'Invalid Password', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Dashboard_Users Change Password",
            "action" => "Edit Dashboard_Users Change Password -> Function: Dashboard_Users/changePassword()",
            "mainResult" => $result[0],
            "result" => $result[1],
            "PostData" => $array,
            "affectedKey" => 'id=' . (isset($id) && $id != '' ? $id : ''),
            "idUser" => Auth::user()->id,
            "username" => Auth::user()->username,
        );
        Custom_Model::trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        return json_encode($result);
    }

    /*Logs*/

    public function user_log_reports()
    {
        $data = array();
        $data["users"] = User::getAllDashboardUsers('0');
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', 'Dashboard_Users');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "User log reports",
            "action" => "View user_log_reports -> Function: Dashboard_Users/user_log_reports()",
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => Auth::user()->id,
            "username" => Auth::user()->username,
        );
        /*==========Log=============*/
        if ($data['permission'][0]->CanView == 1) {
            $idUser = 0;
            if (isset($_GET['u']) && $_GET['u'] != '') {
                $idUser = $_GET['u'];
                $data['getUserData'] = User::getUserLog($idUser);
                $getLastLogin = User::getLastLogin($data['getUserData'][0]->username);
                $data['getUserData'][0]->getLastLogin = (isset($getLastLogin[0]->createdDateTime) && $getLastLogin[0]->createdDateTime != '' ? $getLastLogin[0]->createdDateTime : '');

                $data["getUserLoginActivity"] = User::getUserLoginActivity($idUser);
                $data["getUserActivity"] = User::getUserActivity($idUser);
            }
            $data['user_slug']=$idUser;

            $trackarray["mainResult"] = "Success";
            $trackarray["result"] = "View Success";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('general_settings.user_log_report', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }

    }

}
