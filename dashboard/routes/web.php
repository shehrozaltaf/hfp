<?php

use App\Models\Custom_Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/index', function () {
    if (Auth::user()) {
        return view('dashboard.index');
    } else {
        return view('auth/login');
    }
})->name('/');


Route::get('/dashboard', function () {
    /*==========Log=============*/
    $trackarray = array(
        "activityName" => "Dashboard",
        "action" => "View Dashboard -> Function: Dashboard/index()",
        "PostData" => "",
        "affectedKey" => "",
        "idUser" => Auth::user()->id,
        "username" => Auth::user()->username,
    );
    $trackarray["mainResult"] = "Success";
    $trackarray["result"] = "View Success";
    Custom_Model::trackLogs($trackarray, "all_logs");
    /*==========Log=============*/

    return view('dashboard.index');
})->middleware(['auth'])->name('dashboard');

Route::get('/dashboard2', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard2');


/*=====================================vaccination_report=====================================*/
Route::get('vaccination_report', 'Vaccination_report@index')->middleware(['auth'])->name('vaccination_report');

/*=====================================patient_visit_report=====================================*/
Route::get('patient_visit_report', 'Patient_visit_report@index')->middleware(['auth'])->name('patient_visit_report');

/*=====================================Presenting_Complaint=====================================*/
Route::get('presenting_complaint', 'Presenting_Complaint@index')->middleware(['auth'])->name('presenting_complaint');

/*=====================================Diagnosis=====================================*/
Route::get('diagnosis', 'Diagnosis@index')->middleware(['auth'])->name('diagnosis');



/*=====================================doctors=====================================*/
Route::get('doctors', 'Doctors@index')->middleware(['auth'])->name('doctors');
Route::post('Doctors/addDoctor', 'Doctors@addDoctor')->middleware(['auth'])->name('addDoctor');
Route::get('Doctors/detail/{id?}', 'Doctors@getDoctorData')->middleware(['auth'])->name('getDoctorData');
Route::post('Doctors/editDoctor', 'Doctors@editDoctor')->middleware(['auth'])->name('editDoctor');
Route::post('Doctors/deleteDoctor', 'Doctors@deleteDoctor')->middleware(['auth'])->name('deleteDoctor');

/*=====================================Districts=====================================*/
Route::get('districts', 'Districts@index')->middleware(['auth'])->name('districts');
Route::post('districts/addDistricts', 'Districts@addDistricts')->middleware(['auth'])->name('addDistricts');
Route::get('districts/detail/{id?}', 'Districts@getDistrictsData')->middleware(['auth'])->name('getDistrictsData');
Route::post('districts/editDistricts', 'Districts@editDistricts')->middleware(['auth'])->name('editDistricts');
Route::post('districts/deleteDistricts', 'Districts@deleteDistricts')->middleware(['auth'])->name('deleteDistricts');

Route::post('districts/changeProvince', 'Districts@changeProvince')->middleware(['auth'])->name('changeProvince');
Route::post('districts/changeDistrict', 'Districts@changeDistrict')->middleware(['auth'])->name('changeDistrict');

/*=====================================UC=====================================*/
Route::get('Uc', 'Uc@index')->middleware(['auth'])->name('Uc');
Route::post('Uc/addUc', 'Uc@addUc')->middleware(['auth'])->name('addUc');
Route::get('Uc/detail/{id?}', 'Uc@getUcData')->middleware(['auth'])->name('getUcData');
Route::post('Uc/editUc', 'Uc@editUc')->middleware(['auth'])->name('editUc');
Route::post('Uc/deleteUc', 'Uc@deleteUc')->middleware(['auth'])->name('deleteUc');

/*=====================================health_facility=====================================*/
Route::get('Health_facility', 'Health_facility@index')->middleware(['auth'])->name('Health_facility');
Route::post('health_facility/addHealth_facility', 'Health_facility@addHealth_facility')->middleware(['auth'])->name('addHealth_facility');
Route::get('health_facility/detail/{id?}', 'Health_facility@getHealth_facilityData')->middleware(['auth'])->name('getHealth_facilityData');
Route::post('health_facility/editHealth_facility', 'Health_facility@editHealth_facility')->middleware(['auth'])->name('editHealth_facility');
Route::post('health_facility/deleteHealth_facility', 'Health_facility@deleteHealth_facility')->middleware(['auth'])->name('deleteHealth_facility');


/*=====================================App Users=====================================*/
Route::get('/App_Users', 'App_Users@index')->middleware(['auth'])->name('App_Users');

Route::post('App_Users/addAppUsers', 'App_Users@addAppUsers')->middleware(['auth'])->name('addAppUsers');
Route::get('App_Users/detail/{id?}', 'App_Users@getUserData')->middleware(['auth'])->name('getUserData');
Route::post('App_Users/editAppUsers', 'App_Users@editAppUsers')->middleware(['auth'])->name('editAppUsers');
Route::post('App_Users/resetPwd', 'App_Users@resetPwd')->middleware(['auth'])->name('resetPwd');
Route::post('App_Users/deleteAppUsers', 'App_Users@deleteAppUsers')->middleware(['auth'])->name('deleteAppUsers');

/*=====================================Apps=====================================*/
Route::get('apps', 'Apps@index')->middleware(['auth'])->name('apps');

/*=====================================Settings=====================================*/
Route::prefix('settings')->group(function () {
    Route::get('groups', 'Settings\Group@index')->middleware(['auth'])->name('groups');
    Route::post('groups/addGroup', 'Settings\Group@addGroup')->middleware(['auth'])->name('addGroup');
    Route::get('groups/detail/{id?}', 'Settings\Group@getGroupData')->middleware(['auth'])->name('detailGroup');
    Route::post('groups/editGroup', 'Settings\Group@editGroup')->middleware(['auth'])->name('editGroup');
    Route::post('groups/deleteGroup', 'Settings\Group@deleteGroup')->middleware(['auth'])->name('deleteGroup');

    Route::get('groupSettings/{id?}', 'Settings\GroupSettings@index')->middleware(['auth'])->name('groupSettings');
    Route::get('getFormGroupData/{id?}', 'Settings\GroupSettings@getFormGroupData')->middleware(['auth'])->name('getFormGroupData');
    Route::post('fgAdd', 'Settings\GroupSettings@fgAdd')->middleware(['auth'])->name('fgAdd');

    Route::get('pages', 'Settings\Pages@index')->middleware(['auth'])->name('pages');
    Route::post('pages/addPages', 'Settings\Pages@addPages')->middleware(['auth'])->name('addPages');
    Route::get('pages/detail/{id?}', 'Settings\Pages@getPagesData')->middleware(['auth'])->name('detailPages');
    Route::post('pages/editPages', 'Settings\Pages@editPages')->middleware(['auth'])->name('editPages');
    Route::post('pages/deletePages', 'Settings\Pages@deletePages')->middleware(['auth'])->name('deletePages');


    Route::get('Dashboard_Users', 'Settings\Dashboard_Users@index')->middleware(['auth'])->name('dashboard_users');
    Route::post('Dashboard_Users/addDashboardUsers', 'Settings\Dashboard_Users@addDashboardUsers')->middleware(['auth'])->name('addDashboardUsers');
    Route::get('Dashboard_Users/detail/{id?}', 'Settings\Dashboard_Users@getDashboardUsersData')->middleware(['auth'])->name('getDashboardUsersData');
    Route::post('Dashboard_Users/editDashboardUsers', 'Settings\Dashboard_Users@editDashboardUsers')->middleware(['auth'])->name('editDashboardUsers');
    Route::post('Dashboard_Users/deleteDashboardUsers', 'Settings\Dashboard_Users@deleteDashboardUsers')->middleware(['auth'])->name('deleteDashboardUsers');
    Route::post('Dashboard_Users/resetPwd', 'Settings\Dashboard_Users@resetPwd')->middleware(['auth'])->name('resetPwd');
    Route::get('Dashboard_Users/user_log_reports/{id?}', 'Settings\Dashboard_Users@user_log_reports')->middleware(['auth'])->name('user_log_reports');

});
Route::post('changePassword', 'Settings\Dashboard_Users@changePassword')->middleware(['auth'])->name('changePassword');
/*=====================================Layout Settings=====================================*/
Route::get('layout-{light}', function ($light) {
    session()->put('layout', $light);
    session()->get('layout');
    if ($light == 'vertical-layout') {
        return redirect()->route('pages-vertical-layout');
    }
    return redirect()->route('index');
});
Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');

//Language Change
Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'ur', 'de', 'es', 'fr', 'pt', 'cn', 'ae'])) {
        abort(400);
    }
    Session()->put('locale', $locale);
    Session::get('locale');
    return redirect()->back();
})->name('lang');

require __DIR__ . '/auth.php';
