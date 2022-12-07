<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Diagnosis_report_Model extends Model
{
    use HasFactory;

    protected $table = 'patientdetails';

    public static function getData($searchFilter)
    {

        $sql = DB::table('diagnosis as d')->select(DB::raw("
    uclist.distname,
    uclist.ucname,
    COUNT (DISTINCT pd._uid ) AS patients,
	SUM ( CASE WHEN d.diagnosis = 1 THEN 1 ELSE 0 END ) AS low_birth_weight,
	SUM ( CASE WHEN d.diagnosis = 2 THEN 1 ELSE 0 END ) AS neonatal_jaundice,
	SUM ( CASE WHEN d.diagnosis = 3 THEN 1 ELSE 0 END ) AS neonatal_sepsis,
	SUM ( CASE WHEN d.diagnosis = 4 THEN 1 ELSE 0 END ) AS anemia,
	SUM ( CASE WHEN d.diagnosis = 5 THEN 1 ELSE 0 END ) AS malnutrition,
	SUM ( CASE WHEN d.diagnosis = 6 THEN 1 ELSE 0 END ) AS worm_infestation,
	SUM ( CASE WHEN d.diagnosis = 7 THEN 1 ELSE 0 END ) AS scabies,
	SUM ( CASE WHEN d.diagnosis = 8 THEN 1 ELSE 0 END ) AS tinea_acne_dermatitis,
	SUM ( CASE WHEN d.diagnosis = 9 THEN 1 ELSE 0 END ) AS acute_flaccid_paralysis,
	SUM ( CASE WHEN d.diagnosis = 10 THEN 1 ELSE 0 END ) AS pyrexia_of_unknown_origin,
	SUM ( CASE WHEN d.diagnosis = 11 THEN 1 ELSE 0 END ) AS malaria,
	SUM ( CASE WHEN d.diagnosis = 12 THEN 1 ELSE 0 END ) AS dengue,
	SUM ( CASE WHEN d.diagnosis = 13 THEN 1 ELSE 0 END ) AS typhoid,
	SUM ( CASE WHEN d.diagnosis = 14 THEN 1 ELSE 0 END ) AS chickenpox,
	SUM ( CASE WHEN d.diagnosis = 15 THEN 1 ELSE 0 END ) AS measles,
	SUM ( CASE WHEN d.diagnosis = 16 THEN 1 ELSE 0 END ) AS mumps,
	SUM ( CASE WHEN d.diagnosis = 17 THEN 1 ELSE 0 END ) AS herpes_zoster,
	SUM ( CASE WHEN d.diagnosis = 18 THEN 1 ELSE 0 END ) AS upper_respiratory_tract_infection,
	SUM ( CASE WHEN d.diagnosis = 19 THEN 1 ELSE 0 END ) AS tonsillitis,
	SUM ( CASE WHEN d.diagnosis = 20 THEN 1 ELSE 0 END ) AS otitis_media,
	SUM ( CASE WHEN d.diagnosis = 21 THEN 1 ELSE 0 END ) AS foreign_body,
	SUM ( CASE WHEN d.diagnosis = 22 THEN 1 ELSE 0 END ) AS conjunctivitis,
	SUM ( CASE WHEN d.diagnosis = 23 THEN 1 ELSE 0 END ) AS toothache_dental_caries,
	SUM ( CASE WHEN d.diagnosis = 24 THEN 1 ELSE 0 END ) AS lower_respiratory_tract_infection,
	SUM ( CASE WHEN d.diagnosis = 25 THEN 1 ELSE 0 END ) AS asthma_copd,
	SUM ( CASE WHEN d.diagnosis = 26 THEN 1 ELSE 0 END ) AS gerd,
	SUM ( CASE WHEN d.diagnosis = 27 THEN 1 ELSE 0 END ) AS viral_hepatitis,
	SUM ( CASE WHEN d.diagnosis = 28 THEN 1 ELSE 0 END ) AS acute_gastroenteritis,
	SUM ( CASE WHEN d.diagnosis = 29 THEN 1 ELSE 0 END ) AS dysentery,
	SUM ( CASE WHEN d.diagnosis = 30 THEN 1 ELSE 0 END ) AS anal_fissure_hemorrhoid,
	SUM ( CASE WHEN d.diagnosis = 31 THEN 1 ELSE 0 END ) AS constipation,
	SUM ( CASE WHEN d.diagnosis = 32 THEN 1 ELSE 0 END ) AS cellulitisabscess,
	SUM ( CASE WHEN d.diagnosis = 33 THEN 1 ELSE 0 END ) AS insect_animal_bite,
	SUM ( CASE WHEN d.diagnosis = 34 THEN 1 ELSE 0 END ) AS breast_lump,
	SUM ( CASE WHEN d.diagnosis = 35 THEN 1 ELSE 0 END ) AS mastitisbreast_abscess,
	SUM ( CASE WHEN d.diagnosis = 36 THEN 1 ELSE 0 END ) AS pih_eclampsia,
	SUM ( CASE WHEN d.diagnosis = 37 THEN 1 ELSE 0 END ) AS antenatal_hemorrhage,
	SUM ( CASE WHEN d.diagnosis = 38 THEN 1 ELSE 0 END ) AS hyperemesis_gravidarum,
	SUM ( CASE WHEN d.diagnosis = 39 THEN 1 ELSE 0 END ) AS gestational_diabetes_mellitus,
	SUM ( CASE WHEN d.diagnosis = 40 THEN 1 ELSE 0 END ) AS urinary_tract_infection,
	SUM ( CASE WHEN d.diagnosis = 41 THEN 1 ELSE 0 END ) AS pid,
	SUM ( CASE WHEN d.diagnosis = 42 THEN 1 ELSE 0 END ) AS diabetic_complication,
	SUM ( CASE WHEN d.diagnosis = 43 THEN 1 ELSE 0 END ) AS cerebrovascular_accident,
	SUM ( CASE WHEN d.diagnosis = 44 THEN 1 ELSE 0 END ) AS epilepsy,
	SUM ( CASE WHEN d.diagnosis = 45 THEN 1 ELSE 0 END ) AS depression_anxiety,
	SUM ( CASE WHEN d.diagnosis = 46 THEN 1 ELSE 0 END ) AS trauma,
	SUM ( CASE WHEN d.diagnosis = 47 THEN 1 ELSE 0 END ) AS burns,
	SUM ( CASE WHEN d.diagnosis = 48 THEN 1 ELSE 0 END ) AS renal_stones,
	SUM ( CASE WHEN d.diagnosis = 49 THEN 1 ELSE 0 END ) AS infertility "));
        $sql->leftJoin('patientdetailsV2 as pd', function ($join) {
            $join->on('d._uuid', '=', 'pd._uid')->where(function ($query) {
                $query->where('pd.colflag')
                    ->orWhere('pd.colflag', '=', 0);
            });
        });
        $sql->leftJoin('hf_list', function ($join) {
            $join->on('d.facilityCode', '=', 'hf_list.hf_code')->where(function ($query) {
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
            $query->where('d.colflag')
                ->orWhere('d.colflag', '=', 0);
        });
        $sql->where('d.username', 'Not like', '%testuser2%');
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
            $sql->whereRaw("pd.vdate>='" . $searchFilter['from_slug'] . "'");
        }
        if (isset($searchFilter['to_slug']) && $searchFilter['to_slug'] != '' && $searchFilter['to_slug'] != 0 && $searchFilter['to_slug'] != '1970-01-01') {
            $sql->whereRaw("pd.vdate<='" . $searchFilter['to_slug'] . "'");
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
        $sql->orderBy('uclist.uccode', 'asc');
        return $sql->get();
    }
}
