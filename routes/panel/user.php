<?php

Route::resource('/user-admin', 'Panel\UserAdminController', ['middleware' => ['can:onlyAdmin']]);

Route::get('/user/company/{id}/identify', 'Panel\UserCompanyController@identify')
    ->middleware('can:onlyAdmin')
    ->name('user-company.identify')
    ->where('id', '[0-9]+');
Route::resource('/user-company', 'Panel\UserCompanyController', ['middleware' => ['can:isCompany']]);

Route::get('/user/provider/{id}/identify', 'Panel\UserProviderController@identify')
    ->middleware('can:isCompany')
    ->name('user-provider.identify');
/*->where([
    ['companyId', '[0-9]+'],
    ['providerId', '[0-9]+']
]);*/
Route::resource('/user-provider', 'Panel\UserProviderController', ['middleware' => ['can:isProvider']]);
