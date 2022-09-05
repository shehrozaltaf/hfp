<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Uc_Model extends Model
{
    use HasFactory;

    protected $table = 'uclist';

    public static function getUcDetails($id)
    {
        $data = DB::table('uclist')
            ->where('id', $id)
            ->get();
        return $data;
    }

    public static function checkName($ucname)
    {
        $sql = DB::table('uclist')->select('*')
            ->where('ucname', $ucname);
        $sql->where(function ($query) {
            $query->whereNull('colflag')
                ->orWhere('colflag', '=', '0');
        });
        $data = $sql->get();
        return $data;
    }

    public static function getMaxUcCode($distcode)
    {
        $sql = DB::table('uclist')->select(DB::raw('max(uccode) as max_uc_code'))
            ->where('distcode', $distcode);
        $sql->where(function ($query) {
            $query->whereNull('colflag')
                ->orWhere('colflag', '=', '0');
        });
        $data = $sql->get();
        return $data;
    }
}
