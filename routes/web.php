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

    //Profile
    Route::get('profile', 'Panel\ProfileController@index')->name('profile.index');
    Route::get('profile/edit', 'Panel\ProfileController@edit')->name('profile.edit');
    Route::put('profile/update', 'Panel\ProfileController@update')->name('profile.update');
    Route::get('profile/image', 'Panel\ProfileController@image')->name('profile.image');
    Route::post('profile/upload', 'Panel\ProfileController@upload')->name('profile.upload');

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
    Route::resource('company', 'Panel\CompanyController', ['middleware' => ['can:isAdmin']]);

    //Provider
    Route::get('/provider/{id}/identify', 'Panel\ProviderController@identify')
        ->middleware('can:onlyAdmin')
        ->name('provider.identify');
        //->where('companyId', '[0-9]+');

    Route::match(['GET', 'POST'], '/provider/associate', 'Panel\ProviderController@associate')
        ->middleware('can:isCompany')
        ->name('provider.associate');

    Route::resource('provider', 'Panel\ProviderController', ['middleware' => ['can:isCompany']]);
    //EndProvider

    //Employee
    Route::get('/employee/{providerId}/identify', 'Panel\EmployeeController@identify')
        ->middleware('can:isCompany')
        ->name('employee.identify');
    Route::resource('employee', 'Panel\EmployeeController', ['middleware' => ['can:isProvider']]);
    //EndEmployee

    //Users
    Route::resource('/user-admin', 'Panel\UserAdminController', ['middleware' => ['can:onlyAdmin']]);

    Route::get('/user/company/{id}/identify', 'Panel\UserCompanyController@identify')
        ->middleware('can:onlyAdmin')
        ->name('user-company.identify')
        ->where('id', '[0-9]+');
    Route::resource('/user-company', 'Panel\UserCompanyController', ['middleware' => ['can:isCompany']]);

    Route::get('/user/provider/{id}/identify', 'Panel\UserProviderController@identify')
        ->middleware('can:onlyAdmin')
        ->name('user-provider.identify');
        /*->where([
            ['companyId', '[0-9]+'],
            ['providerId', '[0-9]+']
        ]);*/
    Route::resource('/user-provider', 'Panel\UserProviderController', ['middleware' => ['can:isProvider']]);

});

//Errors
$this->get('/error-custom', function () {
    return view('errors.custom', [
        'message' => \Session::get('message')
    ]);
})->name('error.custom');