<?php

Route::get('profile', 'Panel\ProfileController@index')->name('profile.index');
Route::get('profile/edit', 'Panel\ProfileController@edit')->name('profile.edit');
Route::put('profile/update', 'Panel\ProfileController@update')->name('profile.update');
Route::get('profile/image', 'Panel\ProfileController@image')->name('profile.image');
Route::post('profile/upload', 'Panel\ProfileController@upload')->name('profile.upload');