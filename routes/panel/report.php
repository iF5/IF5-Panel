<?php

Route::get('/report/{id}/identify', 'Panel\ReportController@identify')->middleware('can:onlyAdmin')->name('report.identify');
Route::post('/report/upload', 'Panel\ReportController@upload')->name('report.upload');
Route::resource('report', 'Panel\ReportController', ['middleware' => ['can:isCompany']]);