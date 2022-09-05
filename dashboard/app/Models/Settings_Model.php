<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Settings_Model extends Model
{
    use HasFactory;

    /*Pages*/
    public static function getAllPages()
    {
        $sql = DB::table('pages')->select('*');
        $sql->where('isActive', '=', '1');
        $sql->orderBy('sort_no');
        $sql->orderBy('idPages', 'DESC');
        $data = $sql->get();
        return $data;
    }

    public static function checkPageURL($userName)
    {
        $data = DB::table('pages')
            ->where('pages.isActive', '=', '1')
            ->where('pageUrl', $userName)
            ->get();
        return $data;
    }

    public static function getPagesDetails($id)
    {
        $data = DB::table('pages')
            ->where('idPages', $id)
            ->get();
        return $data;
    }

    /*Group*/
    public static function getAllGroups()
    {
        $sql = DB::table('group')->select('*');
        $sql->where('isActive', '=', '1');
        $sql->orderBy('idGroup');
        $data = $sql->get();
        return $data;
    }

    public static function checkGroupName($userName)
    {
        $data = DB::table('group')
            ->where('group.isActive', '=', '1')
            ->where('groupName', $userName)
            ->get();
        return $data;
    }

    public static function getGroupDetails($id)
    {
        $data = DB::table('group')
            ->where('idGroup', $id)
            ->get();
        return $data;
    }

    /*Group Settings*/
    public static function selectFormGroupData($idGroup)
    {
        $data = DB::table('pagegroup')->select('pagegroup.idPages',
            'pagegroup.CanAdd',
            'pagegroup.CanEdit',
            'pagegroup.CanDelete',
            'pagegroup.CanView',
            'pagegroup.CanViewAllDetail',
            'pagegroup.idPageGroup',
            'pages.pageName',
            'pages.langName',
            'pages.pageUrl',
            'pages.isParent',
            'pages.idParent',
            'pages.menuIcon',
            'pages.menuClass',
            'pages.isMenu',
            'pages.sort_no')
            ->where('pages.isActive', '=', '1')
            ->where('pagegroup.idGroup', '=', $idGroup)
            ->leftJoin('pages', 'pagegroup.idPages', '=', 'pages.idPages')
            ->leftJoin('group', 'pagegroup.idGroup', '=', 'group.idGroup')
            ->orderBy('pages.sort_no', 'ASC')
            ->get();
        return $data;
    }

    public static function fgAdd($Data, $idPageGroup)
    {
        $updateQuery = DB::table('pagegroup')
            ->where('idPageGroup', $idPageGroup)
            ->update($Data);
        if ($updateQuery) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*Menu*/

    public static function getUserRights($idGroup, $CanView = '', $FormName = '')
    {
        $sql = DB::table('pagegroup')->select('pagegroup.idPages',
            'pagegroup.CanAdd',
            'pagegroup.CanEdit',
            'pagegroup.CanDelete',
            'pagegroup.CanView',
            'pagegroup.CanViewAllDetail',
            'pagegroup.idPageGroup',
            'pages.pageName',
            'pages.langName',
            'pages.pageUrl',
            'pages.isParent',
            'pages.idParent',
            'pages.menuIcon',
            'pages.menuClass',
            'pages.isMenu',
            'pages.isTitle',
            'pages.titlePara',
            'pages.sort_no')
            ->where('pages.isActive', '=', '1')
            ->where('pages.isMenu', '=', '1')
            ->where('pagegroup.idGroup', '=', $idGroup)
            ->leftJoin('pages', 'pagegroup.idPages', '=', 'pages.idPages')
            ->orderBy('pages.sort_no', 'ASC');
        if ($CanView != '' && $CanView != '0') {
            $sql->where('pagegroup.CanView', 1);
        }

        if ($FormName != '' && $FormName != '0') {
            $sql->where('pages.pageUrl', $FormName);
        }

        $data = $sql->get();
        return $data;
    }
}
