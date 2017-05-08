<?php

Route::get('report', 'Panel\ReportController@index')->name('report.index');
Route::post('/report/upload', 'Panel\ReportController@upload')->name('report.upload');