<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Vaccination_report_Model extends Model
{
    use HasFactory;

    protected $table = 'patientdetails';

    public static function getData($searchFilter)
    {
        $sql = DB::table('vaccination as vv')->select(DB::raw("
uclist.distname,
uclist.ucname,
COUNT ( pd.col_id ) AS patients,
SUM (CASE WHEN CAST ( pd.ss104y AS INT ) <= 4 THEN 1 ELSE 0 END) AS under_5,
SUM (CASE WHEN pd.ss103 = 2 AND CAST ( pd.ss104y AS INT ) BETWEEN 14 AND 49 THEN 1 ELSE 0 END) AS wra,
SUM ( CASE WHEN vv.bcg = 1 THEN 1 ELSE 0 END ) AS bcg,
SUM ( CASE WHEN vv.opv0 = 1 THEN 1 ELSE 0 END ) AS opv0,
SUM ( CASE WHEN vv.hepb = 1 THEN 1 ELSE 0 END ) AS hepatitis_b,
SUM ( CASE WHEN vv.opv1 = 1 THEN 1 ELSE 0 END ) AS opv1,
SUM ( CASE WHEN vv.penta1 = 1 THEN 1 ELSE 0 END ) AS penta1,
SUM ( CASE WHEN vv.pcv1 = 1 THEN 1 ELSE 0 END ) AS pcv1,
SUM ( CASE WHEN vv.rota1 = 1 THEN 1 ELSE 0 END ) AS rota1,
SUM ( CASE WHEN vv.opv2 = 1 THEN 1 ELSE 0 END ) AS opv2,
SUM ( CASE WHEN vv.penta2 = 1 THEN 1 ELSE 0 END ) AS penta2,
SUM ( CASE WHEN vv.pcv2 = 1 THEN 1 ELSE 0 END ) AS pcv2,
SUM ( CASE WHEN vv.rota2 = 1 THEN 1 ELSE 0 END ) AS rota2,
SUM ( CASE WHEN vv.opv3 = 1 THEN 1 ELSE 0 END ) AS opv3,
SUM ( CASE WHEN vv.penta3 = 1 THEN 1 ELSE 0 END ) AS penta3,
SUM ( CASE WHEN vv.pcv3 = 1 THEN 1 ELSE 0 END ) AS pcv3,
SUM ( CASE WHEN vv.ipv1 = 1 THEN 1 ELSE 0 END ) AS ipv1,
SUM ( CASE WHEN vv.tcv = 1 THEN 1 ELSE 0 END ) AS tcv,
SUM ( CASE WHEN vv.ipv2 = 1 THEN 1 ELSE 0 END ) AS ipv2,
SUM ( CASE WHEN vv.measles2 = 1 THEN 1 ELSE 0 END ) AS measles2 "));
        $sql->leftJoin('patientdetailsV2 as pd', function ($join) {
            $join->on('vv._uuid', '=', 'pd._uid')->where(function ($query) {
                $query->where('pd.colflag')
                    ->orWhere('pd.colflag', '=', 0);
            });
        });
        $sql->leftJoin('hf_list', function ($join) {
            $join->on('vv.facilityCode', '=', 'hf_list.hf_code')->where(function ($query) {
                $query->where('hf_list.colflag')
                    ->orWhere('hf_list.colflag', '=', 0);
            });
        });
        $sql->leftJoin('uclist', function ($join) {
            $join->on('hf_list.uccode', '=', 'uclist.uccode')->where(function ($query) {
                $query->where('uclist.colflag')
                    ->orWhere('uclist.colflag', '=', 0);
            });
        });

        $sql->where('uclist.uccode', '!=', '');
        $sql->where(function ($query) {
            $query->where('vv.colflag')
                ->orWhere('vv.colflag', '=', 0);
        });

        $sql->where('vv.username', 'Not like', '%testuser2%');

        if (isset($searchFilter['province']) && $searchFilter['province'] != '' && $searchFilter['province'] != 0) {
            $sql->where('uclist.provcode', $searchFilter['province']);
        }
        if (isset($searchFilter['dist']) && $searchFilter['dist'] != '' && $searchFilter['dist'] != 0) {
            $sql->where('uclist.distcode', $searchFilter['dist']);
        }
        if (isset($searchFilter['uc']) && $searchFilter['uc'] != '' && $searchFilter['uc'] != 0) {
            $sql->where('uclist.uccode', $searchFilter['uc']);
        }
        if (isset($searchFilter['from_slug']) && $searchFilter['from_slug'] != '' && $searchFilter['from_slug'] != 0 && $searchFilter['from_slug'] != '1970-01-01') {
            $sql->whereRaw("pd.vdate>='".$searchFilter['from_slug']."'");
        }
        if (isset($searchFilter['to_slug']) && $searchFilter['to_slug'] != '' && $searchFilter['to_slug'] != 0 && $searchFilter['to_slug'] != '1970-01-01') {
            $sql->whereRaw("pd.vdate<='".$searchFilter['to_slug']."'");
        }
        if (isset(Auth::user()->district) && Auth::user()->district != '' && Auth::user()->district != '0') {
            $dist = Auth::user()->district;
            $sql->where(function ($query) use ($dist) {
                $exp_dist = explode(',', $dist);
                foreach ($exp_dist as $d) {
                    $query->orWhere('uclist.distcode', '=', trim($d));
                }
            });
        }


        $sql->groupBy('uclist.distname', 'uclist.uccode', 'uclist.ucname');
        $sql->orderBy('uclist.uccode');
        return $sql->get();
    }
}
