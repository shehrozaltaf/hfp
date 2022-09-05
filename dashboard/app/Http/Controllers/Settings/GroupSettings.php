<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Custom_Model;
use App\Models\Group_Model;
use App\Models\Settings_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupSettings extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = array();
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', 'groups');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "GroupSettings",
            "action" => "View GroupSettings -> Function: GroupSettings/index()",
            "PostData" => "",
            "affectedKey" => "",
            "idUser" =>Auth::user()->id,
            "username" => Auth::user()->username,
        );
        /*==========Log=============*/
        if ($data['permission'][0]->CanView == 1) {
            $trackarray["mainResult"] = "Success";
            $trackarray["result"] = "View Success";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('general_settings.groupSettings', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }

    }

    public function getFormGroupData(Request $request)
    {
        $id = $request->input('idGroup');
        $selectFormGroupData = Settings_Model::selectFormGroupData($id);
        return json_encode($selectFormGroupData);
    }


    public function fgAdd()
    {
        $last = "";
        for ($i = 0; $i < count($_POST); $i++) {
            $idPageGroup = $_POST[$i]["idPageGroup"];
            if (isset($_POST[$i]["CanViewAllDetail"])) {
                $postArray = array(
                    'CanViewAllDetail' => ($_POST[$i]["CanViewAllDetail"] == "true") ? 1 : 0
                );
                $last = Settings_Model::fgAdd($postArray, $idPageGroup);
            } elseif (isset($_POST[$i]["CanView"])) {
                $postArray = array(
                    'CanView' => ($_POST[$i]["CanView"] == "true") ? 1 : 0
                );
                $last = Settings_Model::fgAdd($postArray, $idPageGroup);
            } elseif (isset($_POST[$i]["CanAdd"])) {
                $postArray = array(
                    'CanAdd' => ($_POST[$i]["CanAdd"] == "true") ? 1 : 0
                );
                $last = Settings_Model::fgAdd($postArray, $idPageGroup);
            } elseif (isset($_POST[$i]["CanEdit"])) {
                $postArray = array(
                    'CanEdit' => ($_POST[$i]["CanEdit"] == "true") ? 1 : 0
                );
                $last = Settings_Model::fgAdd($postArray, $idPageGroup);
            } elseif (isset($_POST[$i]["CanDelete"])) {
                $postArray = array(
                    'CanDelete' => ($_POST[$i]["CanDelete"] == "true") ? 1 : 0
                );
                $last = Settings_Model::fgAdd($postArray, $idPageGroup);
            }
        }
        echo $last;
    }
}
