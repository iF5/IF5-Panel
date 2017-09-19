<?php

Route::get('{id}/{docTypeId}/checklist', 'Panel\ChecklistController@index')->middleware('can:isAdminAndProvider')->name('checklist.index');
Route::post('upload/{documentId}/{referenceDate}', 'Panel\ChecklistController@upload')->middleware('can:isAdminAndProvider')->name('checklist.upload');
Route::get('checklist-update/{employeeId}/{documentId}/{referenceDate}/{status}', 'Panel\ChecklistController@update')->middleware('can:isAdminAndProvider')->name('checklist.update');
Route::get('download/{employeeId}/{documentId}/{referenceDate}/{finalFileName}', 'Panel\ChecklistController@download')->middleware('can:isAdminAndProvider')->name('checklist.download');
