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
    Route::get('report', 'Panel\ReportController@index');

    //Company
    Route::resource('company', 'Panel\CompanyController', ['middleware' => ['can:isCompany']]);

    //Users
    Route::resource('/user-admin', 'Panel\UserAdminController', ['middleware' => ['can:onlyAdmin']]);

    Route::get('/user/company/{companyId}/identify', 'Panel\UserCompanyController@identify')
        ->middleware('can:onlyAdmin')
        ->name('user-company.identify')
        ->where('companyId', '[0-9]+');
    Route::resource('/user-company', 'Panel\UserCompanyController', ['middleware' => ['can:isCompany']]);

    /*
    Route::get('/user/provider/{companyId}/{providerId}/identify', 'Panel\UserProviderController@identify')
        ->middleware('can:isCompany')
        ->name('user-provider.identify')
        ->where('companyId', '[0-9]+');
    Route::resource('/user-company', 'Panel\UserProviderController', ['middleware' => ['can:isProvider']]);
    */

});

//Errors

$this->get('/access-denied', function(){
    echo 'Esta a&ccedil;&atilde;o n&atilde;o &eacute; autorizada -> <a href="home">In&iacute;cio</a>';
})->name('access.denied');