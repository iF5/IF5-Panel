<?php

Route::group(['middleware' => 'can:onlyAdmin'], function () {
    Route::get('/pendency/{source}', 'Panel\PendencyController@index')->name('pendency.index');
    Route::put('/pendency/{companyId}/{id}/{source}/approve', 'Panel\PendencyController@approve')->name('pendency.approve');
    Route::get('/pendency/{companyId}/{id}/{source}/show', 'Panel\PendencyController@show')->name('pendency.show');
});
