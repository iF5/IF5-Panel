<?php
Route::get('cnae/{cnae}', 'Panel\CnaeController@index')->middleware('can:isAdminAndProvider')->name('cnae.index');
//Route::get('cnae', 'Panel\CnaeController@index')->middleware('can:isAdminAndProvider')->name('cnae.index');