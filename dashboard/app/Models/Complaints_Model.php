<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Complaints_Model extends Model
{

    protected $table = 'complaints';

    public static function getData($searchFilter)
    {

        $sql = DB::table('complaints as cc')->select(DB::raw("
    districts.distname,
	SUM ( CASE WHEN cc.complaints = 1 THEN 1 ELSE 0 END ) AS fever,
	SUM ( CASE WHEN cc.complaints = 2 THEN 1 ELSE 0 END ) AS reluctant_to_feed,
	SUM ( CASE WHEN cc.complaints = 3 THEN 1 ELSE 0 END ) AS lethargy,
	SUM ( CASE WHEN cc.complaints = 4 THEN 1 ELSE 0 END ) AS fits,
	SUM ( CASE WHEN cc.complaints = 5 THEN 1 ELSE 0 END ) AS respiratory_distress,
	SUM ( CASE WHEN cc.complaints = 6 THEN 1 ELSE 0 END ) AS irritability,
	SUM ( CASE WHEN cc.complaints = 7 THEN 1 ELSE 0 END ) AS excessive_crying,
	SUM ( CASE WHEN cc.complaints = 8 THEN 1 ELSE 0 END ) AS cyanosis,
	SUM ( CASE WHEN cc.complaints = 9 THEN 1 ELSE 0 END ) AS umbilical_discharge,
	SUM ( CASE WHEN cc.complaints = 10 THEN 1 ELSE 0 END ) AS congenital_anomalies,
	SUM ( CASE WHEN cc.complaints = 11 THEN 1 ELSE 0 END ) AS itching,
	SUM ( CASE WHEN cc.complaints = 12 THEN 1 ELSE 0 END ) AS skin_rash_boilspustules_abscesses__blisters,
	SUM ( CASE WHEN cc.complaints = 13 THEN 1 ELSE 0 END ) AS flu,
	SUM ( CASE WHEN cc.complaints = 14 THEN 1 ELSE 0 END ) AS cough,
	SUM ( CASE WHEN cc.complaints = 15 THEN 1 ELSE 0 END ) AS sore_throat,
	SUM ( CASE WHEN cc.complaints = 16 THEN 1 ELSE 0 END ) AS eye_rednessitching_in_eyes,
	SUM ( CASE WHEN cc.complaints = 17 THEN 1 ELSE 0 END ) AS mouth_breathing,
	SUM ( CASE WHEN cc.complaints = 18 THEN 1 ELSE 0 END ) AS nasal_blockage,
	SUM ( CASE WHEN cc.complaints = 19 THEN 1 ELSE 0 END ) AS runny_nosebleeding,
	SUM ( CASE WHEN cc.complaints = 20 THEN 1 ELSE 0 END ) AS earachedischarge,
	SUM ( CASE WHEN cc.complaints = 21 THEN 1 ELSE 0 END ) AS impaired_hearing,
	SUM ( CASE WHEN cc.complaints = 22 THEN 1 ELSE 0 END ) AS tooth_ache__dental_caries,
	SUM ( CASE WHEN cc.complaints = 23 THEN 1 ELSE 0 END ) AS burns,
	SUM ( CASE WHEN cc.complaints = 24 THEN 1 ELSE 0 END ) AS minor_trauma__lacerations,
	SUM ( CASE WHEN cc.complaints = 25 THEN 1 ELSE 0 END ) AS chest_pain,
	SUM ( CASE WHEN cc.complaints = 26 THEN 1 ELSE 0 END ) AS apprehensionpalpitation,
	SUM ( CASE WHEN cc.complaints = 27 THEN 1 ELSE 0 END ) AS shortness_of_breath,
	SUM ( CASE WHEN cc.complaints = 28 THEN 1 ELSE 0 END ) AS dizziness,
	SUM ( CASE WHEN cc.complaints = 29 THEN 1 ELSE 0 END ) AS blurred_double_vision,
	SUM ( CASE WHEN cc.complaints = 30 THEN 1 ELSE 0 END ) AS headache,
	SUM ( CASE WHEN cc.complaints = 31 THEN 1 ELSE 0 END ) AS body_aches,
	SUM ( CASE WHEN cc.complaints = 32 THEN 1 ELSE 0 END ) AS backache,
	SUM ( CASE WHEN cc.complaints = 33 THEN 1 ELSE 0 END ) AS neck_pain,
	SUM ( CASE WHEN cc.complaints = 34 THEN 1 ELSE 0 END ) AS joints_pain_stiffness,
	SUM ( CASE WHEN cc.complaints = 35 THEN 1 ELSE 0 END ) AS gait_abnormalities,
	SUM ( CASE WHEN cc.complaints = 36 THEN 1 ELSE 0 END ) AS numbness__tingling_sensation_in_palms_and_soles_extremities,
	SUM ( CASE WHEN cc.complaints = 37 THEN 1 ELSE 0 END ) AS insomnia,
	SUM ( CASE WHEN cc.complaints = 38 THEN 1 ELSE 0 END ) AS pallor,
	SUM ( CASE WHEN cc.complaints = 39 THEN 1 ELSE 0 END ) AS jaundice,
	SUM ( CASE WHEN cc.complaints = 40 THEN 1 ELSE 0 END ) AS weight_loss,
	SUM ( CASE WHEN cc.complaints = 41 THEN 1 ELSE 0 END ) AS flank_pain,
	SUM ( CASE WHEN cc.complaints = 42 THEN 1 ELSE 0 END ) AS burning_micturition,
	SUM ( CASE WHEN cc.complaints = 43 THEN 1 ELSE 0 END ) AS increased_frequency__urgency_of_urination,
	SUM ( CASE WHEN cc.complaints = 44 THEN 1 ELSE 0 END ) AS hematuria,
	SUM ( CASE WHEN cc.complaints = 45 THEN 1 ELSE 0 END ) AS irregular_menstrual_cycle,
	SUM ( CASE WHEN cc.complaints = 46 THEN 1 ELSE 0 END ) AS per_vaginal_bleeding_discharge,
	SUM ( CASE WHEN cc.complaints = 47 THEN 1 ELSE 0 END ) AS lump_in_breast,
	SUM ( CASE WHEN cc.complaints = 48 THEN 1 ELSE 0 END ) AS nipple_discharge,
	SUM ( CASE WHEN cc.complaints = 49 THEN 1 ELSE 0 END ) AS pica,
	SUM ( CASE WHEN cc.complaints = 50 THEN 1 ELSE 0 END ) AS oral_ulcers_thrush,
	SUM ( CASE WHEN cc.complaints = 51 THEN 1 ELSE 0 END ) AS heart_burns__epigastric_pains,
	SUM ( CASE WHEN cc.complaints = 52 THEN 1 ELSE 0 END ) AS decreased_appetite,
	SUM ( CASE WHEN cc.complaints = 53 THEN 1 ELSE 0 END ) AS nausea,
	SUM ( CASE WHEN cc.complaints = 54 THEN 1 ELSE 0 END ) AS vomiting,
	SUM ( CASE WHEN cc.complaints = 55 THEN 1 ELSE 0 END ) AS abdominal_pain,
	SUM ( CASE WHEN cc.complaints = 56 THEN 1 ELSE 0 END ) AS loose_stools,
	SUM ( CASE WHEN cc.complaints = 57 THEN 1 ELSE 0 END ) AS blood_in_stools,
	SUM ( CASE WHEN cc.complaints = 58 THEN 1 ELSE 0 END ) AS constipations,
	SUM ( CASE WHEN cc.complaints = 59 THEN 1 ELSE 0 END ) AS bleeding_per_rectum "));
        $sql->leftJoin('patientdetailsV2 as pd', function ($join) {
            $join->on('cc._uuid', '=', 'pd._uid')->where(function ($query) {
                $query->where('pd.colflag')
                    ->orWhere('pd.colflag', '=', 0);
            });
        });
        $sql->leftJoin('hf_list', function ($join) {
            $join->on('cc.facilityCode', '=', 'hf_list.hf_code')->where(function ($query) {
                $query->where('hf_list.colflag')
                    ->orWhere('hf_list.colflag', '=', 0);
            });
        });
        $sql->leftJoin('districts', function ($join) {
            $join->on('hf_list.distcode', '=', 'districts.distcode')->where(function ($query) {
                $query->where('districts.colflag')
                    ->orWhere('districts.colflag', '=', 0);
            });
        });
        if (isset($searchFilter['distname']) && $searchFilter['distname'] != '' && $searchFilter['distname'] != 0) {
            $sql->where('districts.distname', $searchFilter['distname']);
        }
        if (isset($searchFilter['graph']) && $searchFilter['graph'] == 'u5') {
            $sql->where('pd.ss104y', '<=', '4');
        }

        $sql->where('districts.distname', '!=', '');
        $sql->where('cc.username', 'Not like', '%testuser2%');
        $sql->where(function ($query) {
            $query->where('cc.colflag')
                ->orWhere('cc.colflag', '=', 0);
        });
        $sql->groupBy('districts.distname');
        $sql->orderBy('districts.distname', 'asc');

        return $sql->get();
    }
}
