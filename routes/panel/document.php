<?php

Route::resource('document-types', 'Panel\DocumentTypeController', ['middleware' => ['can:isAdmin']]);