<?php

Route::get('dashboard', 'Panel\DashboardController@index')->middleware('can:isAdmin')->name('dashboard.index');
Route::get('dashboard/{providerId}/employee', 'Panel\DashboardController@employee')->middleware('can:isCompany')->name('dashboard.employee');