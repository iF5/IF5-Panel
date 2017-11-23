<?php


/**
 * For admin
 */
Route::group(['middleware' => 'can:onlyAdmin'], function () {
    Route::get('checklist-company/{id}/identify', 'Panel\ChecklistCompanyController@identify')->name('checklist.company.identify');
    Route::put('checklist-company/approve', 'Panel\ChecklistCompanyController@approve')->name('checklist.company.approve');
    Route::put('checklist-company/disapprove', 'Panel\ChecklistCompanyController@disapprove')->name('checklist.company.disapprove');
    //
    Route::get('checklist-provider/{id}/identify', 'Panel\ChecklistProviderController@identify')->name('checklist.provider.identify');
    Route::put('checklist-provider/approve', 'Panel\ChecklistProviderController@approve')->name('checklist.provider.approve');
    Route::put('checklist-provider/disapprove', 'Panel\ChecklistProviderController@disapprove')->name('checklist.provider.disapprove');
    //
    Route::get('checklist-employee/{id}/identify', 'Panel\ChecklistEmployeeController@identify')->name('checklist.employee.identify');
    Route::put('checklist-employee/approve', 'Panel\ChecklistEmployeeController@approve')->name('checklist.employee.approve');
    Route::put('checklist-employee/disapprove', 'Panel\ChecklistEmployeeController@disapprove')->name('checklist.employee.disapprove');
});

/**
 * For company
 */
Route::group(['middleware' => 'can:isCompany'], function () {
    Route::get('checklist-company/{documentId}/{referenceDate}/{periodicity}/show-pdf', 'Panel\ChecklistCompanyController@showPdf')
        ->name('checklist.company.show.pdf');
    Route::post('checklist-company/store', 'Panel\ChecklistCompanyController@store')->name('checklist.company.store');
    Route::get('checklist-company/{periodicity}', 'Panel\ChecklistCompanyController@index')->name('checklist.company.index');
});

/**
 * For provider and employee
 */
Route::group(['middleware' => 'can:isProvider'], function () {
    Route::get('checklist-provider/{documentId}/{referenceDate}/{periodicity}/show-pdf', 'Panel\ChecklistProviderController@showPdf')
        ->name('checklist.provider.show.pdf');
    Route::post('checklist-provider/store', 'Panel\ChecklistProviderController@store')->name('checklist.provider.store');
    Route::get('checklist-provider/{periodicity}', 'Panel\ChecklistProviderController@index')->name('checklist.provider.index');
    //
    Route::get('checklist-employee/{documentId}/{referenceDate}/{periodicity}/show-pdf', 'Panel\ChecklistEmployeeController@showPdf')
        ->name('checklist.employee.show.pdf');
    Route::post('checklist-employee/store', 'Panel\ChecklistEmployeeController@store')->name('checklist.employee.store');
    Route::get('checklist-employee/{periodicity}', 'Panel\ChecklistEmployeeController@index')->name('checklist.employee.index');
});


