<?php

Route::get('/report/{id}/identify', 'Panel\ReportController@identify')->middleware('can:onlyAdmin')->name('report.identify');
Route::get('report', 'Panel\ReportController@index')->middleware('can:isCompany')->name('report.index');
Route::post('/report/upload', 'Panel\ReportController@upload')->name('report.upload');