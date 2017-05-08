<?php

Route::get('report', 'Panel\ReportController@index')->middleware('can:isCompany')->name('report.index');
Route::post('/report/upload', 'Panel\ReportController@upload')->name('report.upload');