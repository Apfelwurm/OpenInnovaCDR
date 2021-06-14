<?php

use Illuminate\Support\Facades\Route;

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



/**
 * Install
 */
Route::group(['middleware' => ['web', 'App\Http\Middleware\NotInstalled']], function () {
    Route::get('/install', 'App\Http\Controllers\InstallController@installation');
    Route::post('/install', 'App\Http\Controllers\InstallController@install');
});

Route::group(['middleware' => ['App\Http\Middleware\Installed']], function () {

    Route::get('/', 'App\Http\Controllers\HomeController@index');

    Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');
    Route::get('/login', 'App\Http\Controllers\Auth\LoginController@index');

    Route::group(['middleware' => ['auth','App\Http\Middleware\Admin']], function () {
        Route::get('/admin', 'App\Http\Controllers\Admin\AdminController@index');

        /**
         * Users
         */
        Route::get('/admin/users', 'App\Http\Controllers\Admin\UsersController@index');
        Route::post('/admin/users/add', 'App\Http\Controllers\Admin\UsersController@add');
        Route::get('/admin/users/{user}', 'App\Http\Controllers\Admin\UsersController@show');
        Route::delete('/admin/users/{user}', 'App\Http\Controllers\Admin\UsersController@remove');
        Route::post('/admin/users/{user}/admin', 'App\Http\Controllers\Admin\UsersController@grantAdmin');
        Route::delete('/admin/users/{user}/admin', 'App\Http\Controllers\Admin\UsersController@removeAdmin');
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout');
    });


});
