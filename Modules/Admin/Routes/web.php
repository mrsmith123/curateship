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

Route::prefix('admins')->name('admins.')->group(function() {
    // The dashboard routes
    Route::middleware('auth:admins')->group(function () {
        Route::get('/', 'AdminController@index')->name('home');
        Route::get('/users', 'UserController@index');
        Route::any('logout', 'Auth\LoginController@logout')->name('logout');
    });

    // Authentication routes
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
});
