<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Children_vaccination_report_Model extends Model
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
    sum(case when pd.opv0=1           then 1 else 0 end) as opv0,
    sum(case when pd.bcg=1            then 1 else 0 end) as bcg,
    sum(case when pd.hepb=1           then 1 else 0 end) as hepb,
    sum(case when pd.penta1=1  then 1 else 0 end) as penta1,
    sum(case when pd.opv1=1           then 1 else 0 end) as opv1,
    sum(case when pd.pcv1=1           then 1 else 0 end) as pcv1,
    sum(case when pd.rota1=1   then 1 else 0 end) as rota1,
    sum(case when pd.penta2=1  then 1 else 0 end) as penta2,
    sum(case when pd.opv2=1           then 1 else 0 end) as opv2,
    sum(case when pd.pcv2=1           then 1 else 0 end) as pcv2,
    sum(case when pd.rota2=1   then 1 else 0 end) as rota2,
    sum(case when pd.penta3=1  then 1 else 0 end) as penta3,
    sum(case when pd.opv3=1           then 1 else 0 end) as opv3,
    sum(case when pd.pcv3=1           then 1 else 0 end) as pcv3,
    sum(case when pd.ipv1=1           then 1 else 0 end) as ipv1,
    sum(case when pd.measles1=1 then 1 else 0 end) as measles1,
    sum(case when pd.tcv=1            then 1 else 0 end) as tcv,
    sum(case when pd.ipv2=1           then 1 else 0 end) as ipv2,
    sum(case when pd.measles2=1 then 1 else 0 end) as measles2"))
            ->leftJoin('uclist', 'pd.ss104', '=', 'uclist.uccode') ;

        $sql->whereRaw("LEFT ( ss107, charindex( '-', ss107 ) - 1 ) <= 4");

        $sql->groupBy('uclist.distname', 'uclist.uccode', 'uclist.ucname');
        $sql->orderBy('uccode');

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
