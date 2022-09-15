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
        $sql = DB::table('patientdetails as pd')->select(DB::raw("
    uclist.distname,
	uclist.uccode,
	uclist.ucname,
	COUNT ( pd.col_id ) AS opd,
	SUM (CASE WHEN LEFT ( ss107, charindex( '-', ss107 ) - 1 ) >=0 and LEFT ( ss107, charindex( '-', ss107 ) - 1 ) <=4 THEN 1 ELSE 0 END) AS u5, 
SUM (CASE WHEN LEFT ( ss107, charindex( '-', ss107 ) - 1 ) >=15 and LEFT ( ss107, charindex( '-', ss107 ) - 1 )<=49 THEN 1 ELSE 0 END) AS wra, 
SUM (CASE WHEN pd.ss108=2 and pd.ss109=1 THEN 1 ELSE 0 END) AS pws, 
SUM (CASE WHEN pd.vs306a=1 or pd.bcg=1 THEN 1 ELSE 0 END) AS bcg, 
SUM (CASE WHEN pd.vs306b=2 or pd.opv0=1 or pd.opv1=1 or pd.opv2=1 THEN 1 ELSE 0 END) AS opv, 
SUM (CASE WHEN pd.vs306c=3 or pd.pcv1=1 or pd.pcv1=2 or pd.pcv3=1THEN 1 ELSE 0 END) AS pcv, 
SUM (CASE WHEN pd.vs306d=4 or pd.penta1=1 or pd.penta2=1 or pd.penta3=1 THEN 1 ELSE 0 END) AS penta, 
SUM (CASE WHEN pd.vs306e=5 or pd.rota1=1 or pd.rota2=1 THEN 1 ELSE 0 END) AS rota, 
SUM (CASE WHEN pd.vs306f=6 or pd.ipv1=1 or pd.ipv2=1 THEN 1 ELSE 0 END) AS ipv, 
SUM (CASE WHEN pd.vs306g=7 or measles1=1 or measles2=1 THEN 1 ELSE 0 END) AS measles, 
SUM (CASE WHEN pd.tcv=1 THEN 1 ELSE 0 END) AS tcv, 
SUM (CASE WHEN pd.dpt=1 THEN 1 ELSE 0 END) AS dpt, 
SUM (CASE WHEN pd.vs306i=8 THEN 1 ELSE 0 END) AS tt "))
            ->leftJoin('uclist', 'pd.ss104', '=', 'uclist.uccode') ;
        $sql->groupBy('uclist.distname', 'uclist.uccode', 'uclist.ucname');
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
    }
}
