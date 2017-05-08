<?php

Route::get('home', 'Panel\DashboardController@home');
Route::get('dashboard', 'Panel\DashboardController@index');
Route::get('dashboard-employee', 'Panel\DashboardController@employee');