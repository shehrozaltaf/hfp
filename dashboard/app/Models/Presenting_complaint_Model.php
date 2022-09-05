<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Presenting_Complaint_Model extends Model
{
    use HasFactory;

    protected $table = 'patientdetails';

    public static function getData($searchFilter)
    {

        $sql = DB::table('patientview as pd')->select(DB::raw("
    uclist.distname,
	uclist.uccode,
	uclist.ucname, 
	SUM (CASE WHEN pc20101 =1 THEN 1 ELSE 0 END) AS fever, 
    SUM (CASE WHEN pc20102 =2 THEN 1 ELSE 0 END) AS cough,
    SUM (CASE WHEN pc20103 =3 THEN 1 ELSE 0 END) AS sore_troat, 
    SUM (CASE WHEN pc20104 =4 THEN 1 ELSE 0 END) AS skin_problem, 
    SUM (CASE WHEN pc20105 =5 THEN 1 ELSE 0 END) AS Earache_Discharge, 
    SUM (CASE WHEN pc20106 =6 THEN 1 ELSE 0 END) AS Eye_Redness_Discharge, 
    SUM (CASE WHEN pc20107 =7 THEN 1 ELSE 0 END) AS Diarrhea, 
    SUM (CASE WHEN pc20108 =8 THEN 1 ELSE 0 END) AS Dysentery, 
    SUM (CASE WHEN pc20109 =9 THEN 1 ELSE 0 END) AS Abdominal_Pain, 
    SUM (CASE WHEN PC20110 =10 THEN 1 ELSE 0 END) AS Vomiting, 
    SUM (CASE WHEN pc20111 =11 THEN 1 ELSE 0 END) AS Weakness, 
    SUM (CASE WHEN pc20112 =12 THEN 1 ELSE 0 END) AS Vertigo, 
    SUM (CASE WHEN pc20113 =13 THEN 1 ELSE 0 END) AS Headache, 
    SUM (CASE WHEN pc20114 =14 THEN 1 ELSE 0 END) AS Body_Ache, 
    SUM (CASE WHEN pc20115 =15 THEN 1 ELSE 0 END) AS Paleness_Anemia, 
    SUM (CASE WHEN pc20116 =16 THEN 1 ELSE 0 END) AS Yellow_discoloration_of_Eyes_Jaundice, 
    SUM (CASE WHEN pc20117 =17 THEN 1 ELSE 0 END) AS Malnutrition, 
    SUM (CASE WHEN pc20118 =18 THEN 1 ELSE 0 END) AS Problems_in_micturition, 
    SUM (CASE WHEN pc20119 =19 THEN 1 ELSE 0 END) AS Constipation"));
        $sql ->leftJoin('uclist', 'pd.ss104', '=', 'uclist.uccode');
        $sql->groupBy('uclist.distname', 'uclist.uccode', 'uclist.ucname' );
        $sql->orderBy('uclist.uccode', 'asc'); 

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
