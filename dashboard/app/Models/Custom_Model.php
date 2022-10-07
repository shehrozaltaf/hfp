<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Custom_Model extends Model
{
    use HasFactory;

    public static function getDistricts()
    {
//        DB::enableQueryLog();
        $sql = DB::table('districts')->select('*');
        if (isset(Auth::user()->district) && Auth::user()->district != '' && Auth::user()->district != '0') {
            $dist = Auth::user()->district;
            $sql->where(function ($query) use ($dist) {
                $exp_dist = explode(',', $dist);
                foreach ($exp_dist as $d) {
                    $query->orWhere('distcode', '=', trim($d));
                }
            });
        }
        $sql->where(function ($query) {
            $query->whereNull('colflag')
                ->orWhere('colflag', '=', '0');
        });
        $data = $sql->get();
        return $data;
    }

    public static function getAllProvinces()
    {
        $sql = DB::table('province')->select('*');
        $data = $sql->get();
        return $data;
    }

    public static function getAllDistricts()
    {
        $sql = DB::table('districts')->select('*');
        $sql->where(function ($query) {
            $query->whereNull('colflag')
                ->orWhere('colflag', '=', '0');
        });
        $data = $sql->get();
        return $data;
    }

    public static function getAllUc()
    {
        $sql = DB::table('uclist')->select('*');
        $sql->where(function ($query) {
            $query->whereNull('colflag')
                ->orWhere('colflag', '=', '0');
        });
        $data = $sql->get();
        return $data;
    }

    public static function getAllHealth_facility()
    {
        $sql = DB::table('hf_list')->select('hf_list.id',
            'hf_list.distcode',
            'hf_list.uccode',
            'hf_list.hf_code',
            'hf_list.hf_name',
            'uclist.provname',
            'uclist.distname',
        'uclist.ucname')
        ->join('uclist','hf_list.uccode','=','uclist.uccode','left');
        $sql->where(function ($query) {
            $query->whereNull('hf_list.colflag')
                ->orWhere('hf_list.colflag', '=', '0');
        });
        $data = $sql->get();
        return $data;
    }

    // Generate password
    public static function genPassword($password, $salt, $algorithm = '')
    {
        $key_length = 16;
        $saltSize = 16;
        $iterations = 1000;
        if (!isset($algorithm) || $algorithm == '') {
            $algorithm = 'sha1';  // sha1 OR sha512
        }

        $output = hash_pbkdf2(
            $algorithm,
            $password,
            $salt,
            $iterations,
            $key_length / 8,
            true                // IMPORTANT
        );
        // echo base64_encode($salt.$output)."\n";
        return base64_encode($salt . $output);
    }

    // Compare old and new password
    public static function checkPassword($password, $oldPasswordHash)
    {
        $key_length = 16;
        $saltSize = 16;
        $iterations = 1000;
        $salt = substr(base64_decode($oldPasswordHash), 0, $saltSize);
        echo $oldPasswordHash . "\n";
        $genPass = self::genPassword($password, $salt);
        if ($genPass == $oldPasswordHash) {
            return "true";
        } else {
            return "false";
        }
    }

    public static function genPassword2($password, $salt)
    {
        $algorithm = 'sha512';
        $count = 1000;
        $key_length = (64 * 8);
        if (!in_array($algorithm, hash_algos(), true)) {
            exit('pbkdf2: Hash algoritme is niet geinstalleerd op het systeem.');
        }
        if ($count <= 0 || $key_length <= 0) {
            $count = 1000;
            $key_length = 64 * 8;
        }
        $hash_length = strlen(hash($algorithm, "", true));
        $block_count = ceil($key_length / $hash_length);
        $output = "";
        for ($i = 1; $i <= 1; $i++) {
            $last = $salt . pack("N", $i);
            $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
            for ($j = 1; $j < $count; $j++) {
                $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
            }
            $output .= $xorsum;
        }
        return base64_encode($salt) . base64_encode($output);
    }

    public static function checkPassword2($password, $oldPasswordHash)
    {
        $algorithm = 'sha512';
        $count = 1000;
        $key_length = (64 * 8);
        $salt = base64_decode(substr($oldPasswordHash, 0, 24));
        $genPass = self::genPassword($password, $salt);
        if ($genPass == $oldPasswordHash) {
            return "true";
        } else {
            return "false";
        }
    }

    public static function trackLogs($array, $log_type)
    {
        $UserName = (isset($array['username']) ? $array['username'] : Auth::user()->username);
        if ($_SERVER['SERVER_NAME'] == 'vcoe1.aku.edu' || $_SERVER['SERVER_NAME'] == 'vcoe1') {
            $logFileDirPath = 'E:/';
        } else {
            $logFileDirPath = 'C:/';
        }
        $logFileDirPath .= 'PortalFiles/JSONS/' . config('app.name') . '/dashboardLogs/';

        if (!is_dir($logFileDirPath)) {
            mkdir($logFileDirPath, 0777, TRUE);
        }
        $logFilePath = $logFileDirPath . $UserName . 'logs_' . date("n_j_Y") . '.txt';
        $activityName = (isset($array['activityName']) ? $array['activityName'] : 'Invalid activityName');
        $action = (isset($array['action']) ? $array['action'] : 'Invalid Action');
        $affectedKey = (isset($array['affectedKey']) ? $array['affectedKey'] : '');
        $postData = '';
        if (isset($array['PostData']) && $array['PostData'] != '') {
            foreach ($array['PostData'] as $key => $post) {
                $postData .= $key . ' = ' . $post . PHP_EOL;
            }
        }
        $idUser = (isset($array['idUser']) ? $array['idUser'] : Auth::user()->id);
        $mainResult = (isset($array['mainResult']) ? $array['mainResult'] : 'Invalid mainResult');
        $result = (isset($array['result']) ? $array['result'] : 'Invalid Result');
        $Query = (isset($array['Query']) && $array['Query'] != '' ? $array['Query'] : '');
        $log = "UserIPAddress: " . $_SERVER['REMOTE_ADDR'] . ' - ' . date("F-j-Y g:i a") . PHP_EOL .
            "idUser: " . $idUser . ", UserName: " . $UserName . PHP_EOL .
            "Action: " . $action . PHP_EOL .
            "Query: " . $Query . PHP_EOL .
            "AffectedKey: " . $affectedKey . PHP_EOL .
            "mainResult: " . $mainResult . PHP_EOL .
            "Result: " . $result . PHP_EOL .
            "PostData: " . $postData . PHP_EOL .
            "-------------------------------------------------" . PHP_EOL;
        if ($log_type == 'table_logs' || $log_type == 'all_logs') {
            $formArray = array();
            $formArray['idUser'] = $UserName;
            $formArray['activityName'] = $activityName;
            $formArray['actiontype'] = $action;
            $formArray['affectedKey'] = $affectedKey;
            $formArray['mainResult'] = $mainResult;
            $formArray['result'] = $result;
            $formArray['postData'] = $postData;
            $formArray['isActive'] = 1;
            $formArray['createdBy'] = $idUser;
            $formArray['createdDateTime'] = date('Y-m-d H:m:s');
            DB::table('users_dash_activity')->insert($formArray);
            Log::info($result, $formArray);
        }
        if ($log_type == 'user_logs' || $log_type == 'all_logs') {
            /*$txt = fopen($logFilePath, "a") or die("Unable to open file!");
            fwrite($txt, $log);
            fclose($txt);*/
            file_put_contents($logFilePath, $log . "\r\n", FILE_APPEND | LOCK_EX);
        }
        return true;
    }
}
