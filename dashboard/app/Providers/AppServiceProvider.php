<?php

namespace App\Providers;

use App\Models\Settings_Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      /*  $pages=Settings_Model::getUserRights(1,1,'');
        $myresult = array();
        foreach ($pages as $key => $value) {
            if (isset($value->idParent) && $value->idParent != '' && array_key_exists(strtolower($value->idParent), $myresult)) {
                $mykey = strtolower($value->idParent);
                $myresult[strtolower($mykey)]->myrow_options[] = $value;
            } else {
                $mykey = strtolower($value->idPages);
                $myresult[strtolower($mykey)] = $value;
            }
        }
        view::share('pages',$myresult);*/
    }
}
