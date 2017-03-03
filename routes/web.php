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

    //User
    Route::get('user', 'Panel\UserController@index');
    Route::get('user-create', 'Panel\UserController@create');
    Route::get('user-edit/{id}', 'Panel\UserController@edit');

    //Company
    Route::get('company', 'Panel\CompanyController@index');

    //Report
    Route::get('report', 'Panel\ReportController@index');

});