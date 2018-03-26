<?php

Route::get('/employee/{providerId}/identify', 'Panel\EmployeeController@identify')
    ->middleware('can:isCompany')
    ->name('employee.identify');

Route::get('employee/layoff/{employeeId}/{layoffType}', 'Panel\EmployeeController@layoff')
    ->middleware('can:isProvider')
    ->name('employee.layoff');

Route::group(['middleware' => 'can:isProvider'], function () {
    Route::get('employee/register/batch', 'Panel\EmployeeController@registerBatchIndex')->name('employee.register.index');
    Route::post('employee/register/batch/upload', 'Panel\EmployeeController@registerBatchUpload')->name('employee.register.upload');
    Route::get('employee/register/batch/run', 'Panel\EmployeeController@registerBatchRun')->name('employee.register.run');
});

Route::resource('employee', 'Panel\EmployeeController', ['middleware' => ['can:isProvider']]);
