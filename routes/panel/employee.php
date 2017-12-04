<?php

Route::get('/employee/{providerId}/identify', 'Panel\EmployeeController@identify')
    ->middleware('can:isCompany')
    ->name('employee.identify');

Route::get('employee/layoff', 'Panel\EmployeeController@layoff')
    ->middleware('can:isProvider')
    ->name('employee.layoff');

Route::resource('employee', 'Panel\EmployeeController', ['middleware' => ['can:isProvider']]);
