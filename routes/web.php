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
Route::group(['middleware' => ['web', 'notInstalled']], function () {
    Route::get('/install', 'InstallController@installation');
    Route::post('/install', 'InstallController@install');
});

Route::group(['middleware' => ['installed']], function () {

    Route::get('/', 'HomeController@index');

});
