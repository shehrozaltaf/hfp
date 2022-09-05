<?php

namespace App\Providers;

use App\Models\Settings_Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ContentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //compose all the views....
        view()->composer('*', function ($view) {
            $myresult = array();
            if (Auth::check() && isset(Auth::user()->idGroup) && Auth::user()->idGroup!='') {
                $pages = Settings_Model::getUserRights(Auth::user()->idGroup, 1, '');

                foreach ($pages as $key => $value) {
                    if (isset($value->idParent) && $value->idParent != '' && array_key_exists(strtolower($value->idParent), $myresult)) {
                        $mykey = strtolower($value->idParent);
                        $myresult[strtolower($mykey)]->myrow_options[] = $value;
                    } else {
                        $mykey = strtolower($value->idPages);
                        $myresult[strtolower($mykey)] = $value;
                    }
                }
                view::share('pages', $myresult);
                $view->with('pages', $myresult);
            } else {
                view::share('pages', $myresult);
            }
        });


    }
}
