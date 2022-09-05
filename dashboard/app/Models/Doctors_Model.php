<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Doctors_Model extends Model
{
    use HasFactory;

    protected $table = 'doctorlist';

    public static function getData($searchFilter)
    {

        $sql = DB::table('doctorlist')->select(DB::raw("
   	doctorlist.idDoctor,
	doctorlist.dist_id,
	uclist.distname,
	doctorlist.ucCode,
	uclist.ucname,
	doctorlist.staff_name,
	doctorlist.staff_type "))
            ->leftJoin('uclist', 'doctorlist.ucCode', '=', 'uclist.uccode') ;
        $sql->orderBy('doctorlist.idDoctor', 'desc');

        $sql->where(function ($query) {
            $query->where('doctorlist.colflag')
                ->orWhere('doctorlist.colflag', '=', '0');
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

    public static function checkName($distname)
    {
        $sql = DB::table('doctorlist')->select('*')
            ->where('staff_name', $distname);
        $sql->where(function ($query) {
            $query->whereNull('colflag')
                ->orWhere('colflag', '=', '0');
        });
        $data = $sql->get();
        return $data;
    }

    public static function getDoctorDetails($id)
    {
        $data = DB::table('doctorlist')->select(DB::raw("
   	doctorlist.idDoctor,
	doctorlist.dist_id,
	uclist.distname,
	doctorlist.ucCode,
	uclist.provcode,
	uclist.ucname,
	doctorlist.staff_name,
	doctorlist.staff_type "))
            ->leftJoin('uclist', 'doctorlist.ucCode', '=', 'uclist.uccode')
            ->where('doctorlist.idDoctor', $id)
            ->get();
        return $data;
    }

}
