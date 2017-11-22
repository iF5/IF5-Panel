<?php

/**
 * For company
 */

Route::get('checklist-company/{id}/identify', 'Panel\ChecklistCompanyController@identify')
    ->middleware('can:onlyAdmin')->name('checklist.company.identify');

Route::get('checklist-company/{documentId}/{referenceDate}/{periodicity}/show-pdf', 'Panel\ChecklistCompanyController@showPdf')
    ->middleware('can:isCompany')->name('checklist.company.show.pdf');

Route::post('checklist-company/store', 'Panel\ChecklistCompanyController@store')
    ->middleware('can:isCompany')->name('checklist.company.store');

Route::put('checklist-company/approve', 'Panel\ChecklistCompanyController@approve')
    ->middleware('can:onlyAdmin')->name('checklist.company.approve');

Route::put('checklist-company/disapprove', 'Panel\ChecklistCompanyController@disapprove')
    ->middleware('can:onlyAdmin')->name('checklist.company.disapprove');

Route::get('checklist-company/{periodicity}', 'Panel\ChecklistCompanyController@index')
    ->middleware('can:isCompany')->name('checklist.company.index');

/**
 * For provider
 */

Route::get('checklist-provider/{id}/identify', 'Panel\ChecklistProviderController@identify')
    ->middleware('can:onlyAdmin')->name('checklist.provider.identify');

Route::get('checklist-provider/{documentId}/{referenceDate}/{periodicity}/show-pdf', 'Panel\ChecklistProviderController@showPdf')
    ->middleware('can:isProvider')->name('checklist.provider.show.pdf');

Route::post('checklist-provider/store', 'Panel\ChecklistProviderController@store')
    ->middleware('can:isProvider')->name('checklist.provider.store');

Route::put('checklist-provider/approve', 'Panel\ChecklistProviderController@approve')
    ->middleware('can:onlyAdmin')->name('checklist.provider.approve');

Route::put('checklist-provider/disapprove', 'Panel\ChecklistProviderController@disapprove')
    ->middleware('can:onlyAdmin')->name('checklist.provider.disapprove');

Route::get('checklist-provider/{periodicity}', 'Panel\ChecklistProviderController@index')
    ->middleware('can:isProvider')->name('checklist.provider.index');
