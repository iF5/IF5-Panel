<?php

Route::get('checklist-company/{id}/identify', 'Panel\ChecklistController@identify')
    ->middleware('can:onlyAdmin')->name('checklist.company.identify');

Route::get('checklist-company/{periodicity}', 'Panel\ChecklistController@index')
    ->middleware('can:isCompany')->name('checklist.company.index');

Route::post('checklist-company/store', 'Panel\ChecklistController@store')
    ->middleware('can:isCompany')->name('checklist.company.store');

Route::get('checklist-company/download/{entityGroup}/{entityId}/{documentId}/{referenceDate}', 'Panel\ChecklistController@download')
    ->middleware('can:isCompany')->name('checklist.company.download');

Route::put('checklist-company/approve', 'Panel\ChecklistController@approve')
    ->middleware('can:onlyAdmin')->name('checklist.company.approve');

Route::put('checklist-company/disapprove', 'Panel\ChecklistController@disapprove')
    ->middleware('can:onlyAdmin')->name('checklist.company.disapprove');

