<?php

Route::get('/employee/{providerId}/identify', 'Panel\EmployeeController@identify')
    ->middleware('can:isCompany')
    ->name('employee.identify');
Route::resource('employee', 'Panel\EmployeeController', ['middleware' => ['can:isProvider']]);
