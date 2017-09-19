<?php

Route::group(['middleware' => 'can:isAdmin'], function () {
    Route::get('log', 'Panel\LogController@index')->name('log.index');
    Route::get('/log/{id}/show', 'Panel\LogController@show')->name('log.show');
});


