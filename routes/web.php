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

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard-main', 'DashboardMainController@index');

//Dashboard
Route::get('dashboard', 'Panel\DashboardController@index');
Route::get('dashboard-employee', 'Panel\DashboardController@employee');

//Ckecklist
Route::get('checklist', 'Panel\ChecklistController@index');

//User
Route::get('user', 'Panel\UserController@index');
Route::get('user-create', 'Panel\UserController@create');
Route::get('user-edit/{id}', 'Panel\UserController@edit');
