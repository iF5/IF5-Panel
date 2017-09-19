<?php

Route::get('/provider/{id}/identify', 'Panel\ProviderController@identify')
    ->middleware('can:onlyAdmin')
    ->name('provider.identify');
//->where('companyId', '[0-9]+');


Route::match(['GET', 'POST'], '/provider/associate', 'Panel\ProviderController@associate')
    ->middleware('can:isCompany')
    ->name('provider.associate');

Route::resource('provider', 'Panel\ProviderController', ['middleware' => ['can:isCompany']]);
