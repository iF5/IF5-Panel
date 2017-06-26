<?php
Route::get('cnae/{code?}/{cnae?}', 'Panel\CnaeController@index')->middleware('can:isAdminAndProvider')->name('cnae.index');
//Route::get('cnae', 'Panel\CnaeController@index')->middleware('can:isAdminAndProvider')->name('cnae.index');