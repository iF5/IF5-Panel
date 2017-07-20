<?php

Route::group(['middleware' => 'can:isAdmin'], function () {
    Route::get('log', 'Panel\LogController@index')->name('log.index');
    Route::get('/log/{id}/show', 'Panel\LogController@show')->name('log.show');
    Route::get('/log/test', 'Panel\LogController@test')->name('log.test');
    Route::get('/log/test2', 'Panel\LogController@test2')->name('log.test2');
});


