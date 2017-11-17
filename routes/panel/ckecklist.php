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
