<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Dashboard_Model extends Model
{
    use HasFactory;

    protected $table = 'patientdetailsV2';

    public static function getTotalPatient($searchFilter)
    {

        $sql = DB::table('patientdetailsV2 as pd')->select(DB::raw("
	COUNT( pd.col_id ) AS opd,
	SUM ( CASE WHEN CAST ( pd.ss104y AS INT ) <= 4 THEN 1 ELSE 0 END ) AS u5,
	SUM ( CASE WHEN pd.ss103 = 2 AND CAST ( pd.ss104y AS INT ) BETWEEN 14 AND 49 THEN 1 ELSE 0 END ) AS wra,
	SUM ( CASE WHEN pd.ss10703= 3 AND CAST ( pd.ss104y AS INT ) <= 4 THEN 1 ELSE 0 END ) AS vaccination,
	SUM ( CASE WHEN pd.ss10702= 2 AND CAST ( pd.ss104y AS INT ) BETWEEN 14 AND 49  THEN 1 ELSE 0 END ) AS anc
	   ")) ;
        $sql->where(function ($query) {
            $query->where('pd.colflag')
                ->orWhere('pd.colflag', '=', 0);
        });
        $sql->where('pd.username', 'Not like', '%testuser2%');
        $data = $sql->get();
        return $data;
    }
}
