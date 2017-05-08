<?php

Route::get('{id}/{docTypeId}/checklist', 'Panel\ChecklistController@index')->middleware('can:onlyAdmin')->name('checklist.index');
Route::post('upload/{documentId}/{referenceDate}', 'Panel\ChecklistController@upload')->middleware('can:onlyAdmin')->name('checklist.upload');
Route::get('checklist-update/{employeeId}/{documentId}/{referenceDate}/{status}', 'Panel\ChecklistController@update')->middleware('can:onlyAdmin')->name('checklist.update');
Route::get('download/{employeeId}/{documentId}/{referenceDate}/{finalFileName}', 'Panel\ChecklistController@download')->middleware('can:onlyAdmin')->name('checklist.download');
