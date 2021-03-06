<?php

Route::get('/report/{id}/identify', 'Panel\ReportController@identify')->middleware('can:onlyAdmin')->name('report.identify');
Route::get('/report', 'Panel\ReportController@index')->middleware('can:isCompany')->name('report.index');
Route::post('/report/{id}/upload', 'Panel\ReportController@upload')->middleware('can:onlyAdmin')->name('report.upload');
Route::get('/report/{id}/download', 'Panel\ReportController@download')->middleware('can:isCompany')->name('report.download');
Route::group(['middleware' => 'can:isAdmin'], function(){
    Route::resource('report', 'Panel\ReportController', ['except' => ['index']]);
});