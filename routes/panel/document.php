<?php

Route::resource('document-types', 'Panel\DocumentTypeController', ['middleware' => ['can:isAdmin']]);
Route::resource('document-companies', 'Panel\DocumentCompanyController', ['middleware' => ['can:isAdmin']]);