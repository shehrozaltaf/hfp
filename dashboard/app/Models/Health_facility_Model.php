<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Health_facility_Model extends Model
{
    use HasFactory;

    protected $table = 'hf_list';

    public static function getHealth_facilityDetails($id)
    {
        $data = DB::table('hf_list')->select('hf_list.id',
                'uclist.distcode',
                'hf_list.uccode',
                'hf_list.hf_code',
                'hf_list.hf_name',
                'uclist.provcode',
                'uclist.provname',
                'uclist.distname',
                'uclist.ucname')
                ->join('uclist','hf_list.uccode','=','uclist.uccode','left')
            ->where('hf_list.id', $id)
            ->get();
        return $data;
    }

    public static function checkName($distname)
    {
        $sql = DB::table('hf_list')->select('*')
            ->where('hf_name', $distname);
        $sql->where(function ($query) {
            $query->whereNull('colflag')
                ->orWhere('colflag', '=', '0');
        });
        $data = $sql->get();
        return $data;
    }

    public static function getMaxHealth_facilityCode($uccode)
    {
        $sql = DB::table('hf_list')->select(DB::raw('max(hf_code) as max_hf_code'))
            ->where('uccode', $uccode);
        $sql->where(function ($query) {
            $query->whereNull('colflag')
                ->orWhere('colflag', '=', '0');
        });
        $data = $sql->get();
        return $data;
    }
}
