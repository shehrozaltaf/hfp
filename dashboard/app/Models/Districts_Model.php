<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Districts_Model extends Model
{
    use HasFactory;

    protected $table = 'districts';

    public static function getDistrictDetails($id)
    {
        $data = DB::table('districts')
            ->where('id', $id)
            ->get();
        return $data;
    }

    public static function checkName($distname)
    {
        $sql = DB::table('districts')->select('*')
            ->where('distname', $distname);
        $sql->where(function ($query) {
            $query->whereNull('colflag')
                ->orWhere('colflag', '=', '0');
        });
        $data = $sql->get();
        return $data;
    }

    public static function getMaxDistrictCode($provcode)
    {
        $sql = DB::table('districts')->select(DB::raw('max(distcode) as max_dist_code'))
            ->where('provcode', $provcode);
        $sql->where(function ($query) {
            $query->whereNull('colflag')
                ->orWhere('colflag', '=', '0');
        });
        $data = $sql->get();
        return $data;
    }

    public static function getDistrictByProvince($provcode)
    {
        $sql = DB::table('districts')->select('*')
            ->where('provcode', $provcode);
        $sql->where(function ($query) {
            $query->whereNull('colflag')
                ->orWhere('colflag', '=', '0');
        });
        return $sql->get();
    }

    public static function getUcByDistrict($dist_id)
    {
        $sql = DB::table('uclist')->select('*')
            ->where('distcode', $dist_id);
        $sql->where(function ($query) {
            $query->whereNull('colflag')
                ->orWhere('colflag', '=', '0');
        });
        return $sql->get();
    }
}
