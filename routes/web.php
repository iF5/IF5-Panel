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

//Authentication
//Auth::routes();
$this->get('/', 'Auth\LoginController@showLoginForm');
$this->get('/login', 'Auth\LoginController@showLoginForm');
$this->post('/login', 'Auth\LoginController@login')->name('login');
$this->get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {

    $path = sprintf('%s/%s/', __DIR__, 'panel');
    $files = glob("{$path}*.php");

    foreach ($files as $file) {
        require "{$file}";
    }

});

//Errors
$this->get('/error-custom', function () {
    return view('errors.custom', [
        'message' => \Session::get('message')
    ]);
})->name('error.custom');

\Route::auth();
