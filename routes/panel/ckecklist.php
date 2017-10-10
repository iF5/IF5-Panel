<?php

/**
Route::get('{id}/{docTypeId}/checklist', 'Panel\ChecklistController@index')->middleware('can:isAdminAndProvider')->name('checklist.index');
Route::post('upload/{documentId}/{referenceDate}', 'Panel\ChecklistController@upload')->middleware('can:isAdminAndProvider')->name('checklist.upload');
Route::get('checklist-update/{employeeId}/{documentId}/{referenceDate}/{status}', 'Panel\ChecklistController@update')->middleware('can:isAdminAndProvider')->name('checklist.update');
Route::get('download/{employeeId}/{documentId}/{referenceDate}/{finalFileName}', 'Panel\ChecklistController@download')->middleware('can:isAdminAndProvider')->name('checklist.download');
 */

Route::get('checklist-company/{id}/identify', 'Panel\ChecklistController@identify')
    ->middleware('can:isCompany')->name('checklist.company.identify');

Route::get('checklist-company/{periodicity}', 'Panel\ChecklistController@index')
    ->middleware('can:isAdminAndProvider')->name('checklist.company.index');

Route::post('checklist-company/store', 'Panel\ChecklistController@store')
    ->middleware('can:onlyAdmin')->name('checklist.company.store');


Route::post('checklist-company/download/{entityGroup}/{entityId}/{documentId}/{referenceDate}', 'Panel\ChecklistController@download')
    ->middleware('can:onlyAdmin')->name('checklist.company.download');