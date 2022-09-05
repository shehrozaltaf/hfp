<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Custom_Model;
use App\Models\Settings_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Pages extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = array();
        $data["data"] = Settings_Model::getAllPages();
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', 'pages');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Pages",
            "action" => "View Pages -> Function: Pages/index()",
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
            return view('general_settings.pages', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }

    }

    public function addPages(Request $request)
    {
        $array = array();
        $array['pageName'] = ucfirst($request->input('pageName'));
        $array['pageUrl'] = $request->input('pageUrl');
        if ($request->input('menuParent') == 1 || $request->input('menuParent') == '1') {
            $array['isParent'] = 1;
            $array['idParent'] = $request->input('idParent');
        } else {
            $array['isParent'] = 0;
            $array['idParent'] = 0;
        }
        $array['menuIcon'] = $request->input('menuIcon');
        $array['menuClass'] = $request->input('menuClass');
        $array['isMenu'] = $request->input('isMenu');
        $array['sort_no'] = $request->input('sort_no');
        $array['isActive'] = 1;
        $array['createdBy'] = auth()->id();
        $array['createdDateTime'] = date('Y-m-d H:i:s');
        $checkName = Settings_Model::checkPageURL($array['pageUrl']);
        if (count($checkName) == 0) {
            $insertData = DB::table('pages')->insertGetId($array);
            if ($insertData) {
                $groups = Settings_Model::getAllGroups();
                foreach ($groups as $p) {
                    $pagePagesArray = array();
                    $pagePagesArray['idPages'] = $insertData;
                    $pagePagesArray['idGroup'] = $p->idGroup;
                    $pagePagesArray['CanAdd'] = 0;
                    $pagePagesArray['CanEdit'] = 0;
                    $pagePagesArray['CanDelete'] = 0;
                    $pagePagesArray['CanView'] = 0;
                    $pagePagesArray['CanViewAllDetail'] = 0;
                    $pagePagesArray['isActive'] = 1;
                    DB::table('pagegroup')->insert($pagePagesArray);
                }
                $result = array('Success', 'Successfully Inserted', 'success');
            } else {
                $result = array('Error', 'Something went wrong in inserting data', 'danger');
            }
        } else {
            $result = array('Error', 'Page URL already exist', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Pages",
            "action" => "Add Pages -> Function: Pages/addPages()",
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

    public function getPagesData(Request $request)
    {
        $id = $request->input('id');
        $getPagesData = Settings_Model::getPagesDetails($id);
        return json_encode($getPagesData);
    }

    public function editPages(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '') {
            $array['pageName'] = ucfirst($request->input('pageName'));
            if ($request->input('menuParent') == 1 || $request->input('menuParent') == '1') {
                $array['isParent'] = 1;
                $array['idParent'] = $request->input('idParent');
            } else {
                $array['isParent'] = 0;
                $array['idParent'] = 0;
            }
            $array['menuIcon'] = $request->input('menuIcon');
            $array['menuClass'] = $request->input('menuClass');
            $array['isMenu'] = $request->input('isMenu');
            $array['sort_no'] = $request->input('sort_no');
            $array['updateBy'] = auth()->id();
            $array['updatedDateTime'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('pages')
                ->where('idPages', $id)
                ->update($array);
            if ($updateQuery) {
                $result = array('Success', 'Successfully Edited', 'success');
            } else {
                $result = array('Error', 'Something went wrong in editing data', 'danger');
            }
        } else {
            $result = array('Error', 'Invalid Page Id', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Pages",
            "action" => "Edit Pages -> Function: Pages/editPages()",
            "mainResult" => $result[0],
            "result" => $result[1],
            "PostData" => $array,
            "affectedKey" => 'idPages=' . (isset($id) && $id != '' ? $id : ''),
            "idUser" => Auth::user()->id,
            "username" => Auth::user()->username,
        );
        Custom_Model::trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        return json_encode($result);
    }

    public function deletePages(Request $request)
    {
        $id = $request->input('id');
        $array = array();
        if (isset($id) && $id != '') {
            $array['isActive'] = 0;
            $array['deleteBy'] = auth()->id();
            $array['deletedDateTime'] = date('Y-m-d H:i:s');
            $updateQuery = DB::table('pages')
                ->where('idPages', $id)
                ->update($array);
            if ($updateQuery) {
                $result = array('Success', 'Successfully Deleted', 'success');
            } else {
                $result = array('Error', 'Something went wrong in deleting data', 'danger');
            }
        } else {
            $result = array('Error', 'Invalid Page Id', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Pages",
            "action" => "Delete Pages -> Function: Pages/deletePages()",
            "mainResult" => $result[0],
            "result" => $result[1],
            "PostData" => $array,
            "affectedKey" => 'idPages=' . (isset($id) && $id != '' ? $id : ''),
            "idUser" => Auth::user()->id,
            "username" => Auth::user()->username,
        );
        Custom_Model::trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        return json_encode($result);
    }

}
