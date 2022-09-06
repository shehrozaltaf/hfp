<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Diagnosis_Model extends Model
{
    use HasFactory;

    protected $table = 'patientdetails';

    public static function getData($searchFilter)
    {

        $sql = DB::table('patientview as pd')->select(DB::raw("
    uclist.distname,
	uclist.uccode,
	uclist.ucname, 
    SUM (CASE WHEN DI20201 =1 THEN 1 ELSE 0 END) AS upper_respiratory_tract_infection, 
    SUM (CASE WHEN DI20202 =2 THEN 1 ELSE 0 END) AS lower_respiratory_tract_infection,
    SUM (CASE WHEN DI20203 =3 THEN 1 ELSE 0 END) AS allergic_rhinitis, 
    SUM (CASE WHEN DI20204 =4 THEN 1 ELSE 0 END) AS acute_gastroenteritis, 
    SUM (CASE WHEN DI20205 =5 THEN 1 ELSE 0 END) AS dysentery, 
    SUM (CASE WHEN DI20206 =6 THEN 1 ELSE 0 END) AS typhoid_fever, 
    SUM (CASE WHEN DI20207 =7 THEN 1 ELSE 0 END) AS cellulitis, 
    SUM (CASE WHEN DI20208 =8 THEN 1 ELSE 0 END) AS ophthalmitis, 
    SUM (CASE WHEN DI20209 =9 THEN 1 ELSE 0 END) AS otitis_media, 
    SUM (CASE WHEN DI20210 =10 THEN 1 ELSE 0 END) AS scabies, 
    SUM (CASE WHEN DI20211 =11 THEN 1 ELSE 0 END) AS anemia, 
    SUM (CASE WHEN DI20212 =12 THEN 1 ELSE 0 END) AS jaundice, 
    SUM (CASE WHEN DI20213 =13 THEN 1 ELSE 0 END) AS malaria, 
    SUM (CASE WHEN DI20214 =14 THEN 1 ELSE 0 END) AS urinary_tract_infection, 
    SUM (CASE WHEN DI20215 =15 THEN 1 ELSE 0 END) AS pyrexia_of_unknown_origin, 
    SUM (CASE WHEN DI20216 =16 THEN 1 ELSE 0 END) AS pre_eclampsia, 
    SUM (CASE WHEN DI20217 =17 THEN 1 ELSE 0 END) AS eclampsia, 
    SUM (CASE WHEN DI20218 =18 THEN 1 ELSE 0 END) AS undernutrition, 
    SUM (CASE WHEN DI20219 =19 THEN 1 ELSE 0 END) AS obesity"));
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
