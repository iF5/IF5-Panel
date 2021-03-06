<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

function loadRoute($directoryName)
{
    $files = glob(sprintf('%s/%s/', __DIR__, $directoryName) . '*.php');
    foreach ($files as $file) {
        require "{$file}";
    }
}

#Authentication
Auth::routes();
$this->get('/', 'Auth\LoginController@showLoginForm');
$this->get('/login', 'Auth\LoginController@showLoginForm');
$this->post('/login', 'Auth\LoginController@login')->name('login');
$this->get('/logout', 'Auth\LoginController@logout')->name('logout');
#Password-Reset
$this->get('/password/reset', 'Auth\PasswordController@index')->name('password-reset.index');
$this->post('/password/reset', 'Auth\PasswordController@check')->name('password-reset.check');
$this->get('/password/reset/{token}', 'Auth\PasswordController@edit')->name('password-reset.edit');
$this->post('/password/update', 'Auth\PasswordController@update')->name('password-reset.update');

Route::group(['middleware' => 'auth'], function () {
    loadRoute('panel');
});

//Errors
$this->get('/error-custom', function () {
    return view('errors.custom', [
        'message' => \Session::get('message')
    ]);
})->name('error.custom');