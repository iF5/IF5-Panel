<?php

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

//Authentication
//Auth::routes();
$this->get('/', 'Auth\LoginController@showLoginForm');
$this->get('/login', 'Auth\LoginController@showLoginForm');
$this->post('/login', 'Auth\LoginController@login')->name('login');
$this->get('/logout', 'Auth\LoginController@logout')->name('logout');


Route::group(['middleware' => 'auth'], function () {

    //Dashboard
    Route::get('home', 'Panel\DashboardController@index');
    Route::get('dashboard', 'Panel\DashboardController@index');
    Route::get('dashboard-employee', 'Panel\DashboardController@employee');

    //Ckecklist
    Route::get('checklist', 'Panel\ChecklistController@index');

    //Report
    Route::get('report', 'Panel\ReportController@index')->name('report.index');
    Route::post('/report/upload', 'Panel\ReportController@upload')->name('report.upload');

    //Company
    Route::resource('company', 'Panel\CompanyController', ['middleware' => ['can:isCompany']]);

    //Provider
    Route::get('/provider/{companyId}/identify', 'Panel\ProviderController@identify')
        ->middleware('can:onlyAdmin')
        ->name('provider.identify')
        ->where('companyId', '[0-9]+');
    Route::resource('provider', 'Panel\ProviderController', ['middleware' => ['can:isProvider']]);

    //Users
    Route::resource('/user-admin', 'Panel\UserAdminController', ['middleware' => ['can:onlyAdmin']]);

    Route::get('/user/company/{companyId}/identify', 'Panel\UserCompanyController@identify')
        ->middleware('can:onlyAdmin')
        ->name('user-company.identify')
        ->where('companyId', '[0-9]+');
    Route::resource('/user-company', 'Panel\UserCompanyController', ['middleware' => ['can:isCompany']]);

    Route::get('/user/provider/{companyId}/{providerId}/identify', 'Panel\UserProviderController@identify')
        ->middleware('can:onlyAdmin')
        ->name('user-provider.identify');
        /*->where([
            ['companyId', '[0-9]+'],
            ['providerId', '[0-9]+']
        ]);*/
    Route::resource('/user-provider', 'Panel\UserProviderController', ['middleware' => ['can:isProvider']]);

});

//Errors
$this->get('/access-denied', function () {
    return view('errors.access-denied');
})->name('access.denied');