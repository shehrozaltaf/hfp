<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Patient_visit_report_Model extends Model
{
    use HasFactory;

    protected $table = 'patientdetails';

    public static function getData($searchFilter)
    {

        $sql = DB::table('patientdetailsV2 as pd')->select(DB::raw("
    uclist.distname,
	uclist.ucname,
	pd.ss100 AS doctor_name,
	COUNT( pd.col_id ) AS total_patients,
	SUM ( CASE WHEN CAST ( pd.ss104y AS INT ) <= 4 THEN 1 ELSE 0 END ) AS under_5,
	SUM ( CASE WHEN pd.ss103 = 2 AND CAST ( pd.ss104y AS INT ) BETWEEN 14 AND 49 THEN 1 ELSE 0 END ) AS wra,
	SUM ( CASE WHEN pd.sh301= 1 THEN 1 ELSE 0 END ) AS pw,
	SUM ( CASE WHEN ( CAST ( pd.ss104y AS INT ) < 15 OR CAST ( pd.ss104y AS INT ) > 49 )
			AND pd.ss10702!= 2
			AND pd.ss10704!= 4
			AND pd.ss10703!= 3
			THEN 1 ELSE 0
			END
			) AS other,
	SUM ( CASE WHEN pd.ss10703= 3 AND CAST ( pd.ss104y AS INT ) <= 4 THEN 1 ELSE 0 END ) AS vaccination,
	SUM ( CASE WHEN pd.ss10702= 2 AND CAST ( pd.ss104y AS INT ) BETWEEN 14 AND 49  THEN 1 ELSE 0 END ) AS anc,
    SUM ( CASE WHEN pd.ss10704= 4 THEN 1 ELSE 0 END ) AS pnc")) ;

        $sql->leftJoin('hf_list', function ($join) {
            $join->on('pd.facilityCode', '=', 'hf_list.hf_code')->where(function ($query) {
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

        $sql->where('pd.username', 'Not like', '%testuser2%');

        $sql->where('uclist.uccode', '!=', '');
        $sql->where(function ($query) {
            $query->where('pd.colflag')
                ->orWhere('pd.colflag', '=', '0');
        });
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

        $sql->groupBy('uclist.distname', 'uclist.uccode', 'uclist.ucname','pd.ss100');
        $sql->orderBy('uclist.uccode', 'asc');
        $sql->orderBy('pd.ss100', 'asc');
        return $sql->get();
    }
  /*  public static function getData($searchFilter)
    {

        $sql = DB::table('patientview as pd')->select(DB::raw("
    uclist.distname,
	uclist.uccode,
	uclist.ucname,
	pd.pc201a AS dr_name,
	COUNT ( pd.col_id ) AS opd,
	SUM (CASE WHEN ageYear >=0 and  ageYear <=4 THEN 1 ELSE 0 END) AS u5,
	SUM ( CASE WHEN ageYear >= 15 AND ageYear <= 49 AND pd.ss108= 2 THEN 1 ELSE 0 END ) AS wra,
	SUM ( CASE WHEN pd.pw= 1 THEN 1 ELSE 0 END ) AS pws,
	SUM ( CASE WHEN ( ageYear < 15 OR ageYear > 49 )
			AND pd.anc!= 1
			AND pd.pnc!= 1
			AND pd.vaccination!= 1
			AND pd.ss108= 1 THEN
				1 ELSE 0
			END
			) AS other,
	SUM ( CASE WHEN pd.anc= 1 THEN 1 ELSE 0 END ) AS anc,
	SUM ( CASE WHEN pd.pnc= 1 THEN 1 ELSE 0 END ) AS pnc,
	SUM ( CASE WHEN pd.vaccination= 1 THEN 1 ELSE 0 END ) AS vaccination "))
        ->leftJoin('uclist', 'pd.ss104', '=', 'uclist.uccode') ;
        $sql->groupBy('uclist.distname', 'uclist.uccode', 'uclist.ucname','pd.pc201a');
        $sql->orderBy('uclist.uccode', 'asc');
        $sql->orderBy('pd.pc201a', 'asc');

        $sql->where(function ($query) {
            $query->where('pd.colflag')
                ->orWhere('pd.colflag', '=', '0');
        });
        $sql->where(function ($query) {
            $query->where('uclist.colflag')
                ->orWhere('uclist.colflag', '=', '0');
        });

        $sql->where('pd.username', 'Not like', '%testuser2%');
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
            $sql->whereRaw("pd.ss101>='".$searchFilter['from_slug']."'");
        }
        if (isset($searchFilter['to_slug']) && $searchFilter['to_slug'] != '' && $searchFilter['to_slug'] != 0 && $searchFilter['to_slug'] != '1970-01-01') {
            $sql->whereRaw("pd.ss101<='".$searchFilter['to_slug']."'");
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
        $data = $sql->get();
        return $data;
    }*/
}
