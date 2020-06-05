<?php

/*
|--------------------------------------------------------------------------
| Installation Routes
|--------------------------------------------------------------------------
|
| These are custom installation routes meant ONLY FOR INSTALLATION.
| Please NEVER use these routes outside of this file.
|
*/

# The route group options.
$options = [
    'prefix' => 'install',
    'as' => 'LaravelInstaller::',
    'namespace' => 'App\Http\Controllers',
    'middleware' => ['web'],
];

Route::group($options, function () {
    Route::middleware('install')->group(function () {
        // Your installation routes here
    });

    // Admin installation routes
    Route::middleware('admin_installed')->group(function () {
        Route::get('admin', 'InstallationController@showAdminForm')->name('admin');
        Route::post('admin', 'InstallationController@storeAdmin')->name('admin.create');
        Route::any('admin/skip', 'InstallationController@skipAdminCreation')->name('admin.skip');
    });
});