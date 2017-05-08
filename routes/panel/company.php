<?php

Route::resource('company', 'Panel\CompanyController', ['middleware' => ['can:isAdmin']]);