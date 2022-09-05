<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class App_Users_Model extends Model
{
    use HasFactory;

    protected $table = 'users';


    public static function getAllData()
    {
        $sql = DB::table('users')->select('users.id',
	'users.username',
	'users.password',
	'users.full_name',
	'users.auth_level',
	'users.enabled',
	'users.designation',
	'users.dist_id',
	'users.attempt',
	'users.attemptDateTime',
	'users.isNewUser',
	'users.lastPwdChangeBy',
	'users.lastPwd_dt',
	'users.uccode',
	'uclist.ucname',
	'users.vtype',
	'districts.provname',
	'districts.distname',
	'districts.provcode')
        ->join('districts','users.dist_id','=','districts.distcode','LEFT')
        ->join('uclist','users.uccode','=','uclist.uccode','LEFT')
        ->orderBy('users.id','desc');
        $sql->where('users.enabled', '=', '1');
        $sql->where(function ($query) {
            $query->whereNull('users.colflag')
                ->orWhere('users.colflag', '=', '0');
        });
        $data = $sql->get();
        return $data;
    }

    public static function checkName($userName)
    {
        $data = DB::table('users')
            ->where('users.enabled', '=', '1')
            ->where('username', $userName)
            ->get();
        return $data;
    }

    public static function getUserDetails($id)
    {
        $data = DB::table('users')
            ->where('id', $id)
            ->get();
        return $data;
    }

}
