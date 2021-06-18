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
         * Reports
         */
        Route::get('/admin/reports/templates', 'App\Http\Controllers\Admin\ReportTemplateController@index');

        Route::group(['middleware' => ['App\Http\Middleware\ReportNotRunning']], function () {
            Route::post('/admin/reports/templates/add', 'App\Http\Controllers\Admin\ReportTemplateController@add');
        });

        Route::get('/admin/reports/templates/{reportTemplate}', 'App\Http\Controllers\Admin\ReportTemplateController@show');

        Route::group(['middleware' => ['App\Http\Middleware\ReportNotRunning']], function () {
            Route::post('/admin/reports/templates/{reportTemplate}', 'App\Http\Controllers\Admin\ReportTemplateController@update');
            Route::delete('/admin/reports/templates/{reportTemplate}/delete', 'App\Http\Controllers\Admin\ReportTemplateController@remove');
        });

        Route::get('/admin/reports', 'App\Http\Controllers\Admin\ReportController@index');
        Route::get('/admin/reports/{report}', 'App\Http\Controllers\Admin\ReportController@show');


       /**
        /**
         * Users
         */
        Route::get('/admin/users', 'App\Http\Controllers\Admin\UserController@index');
        Route::post('/admin/users/add', 'App\Http\Controllers\Admin\UserController@add');
        Route::get('/admin/users/{user}', 'App\Http\Controllers\Admin\UserController@show');
        Route::delete('/admin/users/{user}', 'App\Http\Controllers\Admin\UserController@remove');
        Route::post('/admin/users/{user}/admin', 'App\Http\Controllers\Admin\UserController@grantAdmin');
        Route::delete('/admin/users/{user}/admin', 'App\Http\Controllers\Admin\UserController@removeAdmin');
        /**
        * Organisation Units
         */
        Route::get('/admin/organisationunits', 'App\Http\Controllers\Admin\OrganisationUnitController@index');
        Route::group(['middleware' => ['App\Http\Middleware\ReportNotRunning']], function () {
            Route::post('/admin/organisationunits/add', 'App\Http\Controllers\Admin\OrganisationUnitController@store');
            Route::post('/admin/organisationunits/{organisationUnit}', 'App\Http\Controllers\Admin\OrganisationUnitController@update');
        });
        Route::get('/admin/organisationunits/{organisationUnit}', 'App\Http\Controllers\Admin\OrganisationUnitController@show');
        Route::group(['middleware' => ['App\Http\Middleware\ReportNotRunning']], function () {
            Route::delete('/admin/organisationunits/{organisationUnit}/delete', 'App\Http\Controllers\Admin\OrganisationUnitController@remove');
        });
        /**
        * caller prefixes
         */
        Route::get('/admin/callerprefixes', 'App\Http\Controllers\Admin\CallerPrefixController@index');
        Route::group(['middleware' => ['App\Http\Middleware\ReportNotRunning']], function () {
            Route::post('/admin/callerprefixes/add', 'App\Http\Controllers\Admin\CallerPrefixController@store');
            Route::post('/admin/callerprefixes/{callerPrefix}', 'App\Http\Controllers\Admin\CallerPrefixController@update');
        });
        Route::get('/admin/callerprefixes/{callerPrefix}', 'App\Http\Controllers\Admin\CallerPrefixController@show');
        Route::group(['middleware' => ['App\Http\Middleware\ReportNotRunning']], function () {
            Route::delete('/admin/callerprefixes/{callerPrefix}/delete', 'App\Http\Controllers\Admin\CallerPrefixController@remove');
        });
        /**
        * Callers
        */
        Route::get('/admin/callers', 'App\Http\Controllers\Admin\CallerController@index');
        Route::group(['middleware' => ['App\Http\Middleware\ReportNotRunning']], function () {
        Route::post('/admin/callers/add', 'App\Http\Controllers\Admin\CallerController@store');
            Route::post('/admin/callers/{caller}/assign/{organisationUnit}', 'App\Http\Controllers\Admin\CallerController@assign');
            Route::post('/admin/callers/{caller}/unassign', 'App\Http\Controllers\Admin\CallerController@unassign');
            Route::post('/admin/callers/{caller}', 'App\Http\Controllers\Admin\CallerController@update');
        });
        Route::get('/admin/callers/{caller}', 'App\Http\Controllers\Admin\CallerController@show');
        Route::group(['middleware' => ['App\Http\Middleware\ReportNotRunning']], function () {
            Route::delete('/admin/callers/{caller}/delete', 'App\Http\Controllers\Admin\CallerController@remove');
        });
        /**
         * NumberFilterSettings
         */
        Route::get('/admin/numberfiltersettings', 'App\Http\Controllers\Admin\NumberFilterSettingsController@index');
        Route::group(['middleware' => ['App\Http\Middleware\ReportNotRunning']], function () {
            Route::post('/admin/numberfiltersettings/add', 'App\Http\Controllers\Admin\NumberFilterSettingsController@add');
        });
        Route::get('/admin/numberfiltersettings/{numberFilterSetting}', 'App\Http\Controllers\Admin\NumberFilterSettingsController@show');
        Route::group(['middleware' => ['App\Http\Middleware\ReportNotRunning']], function () {
            Route::post('/admin/numberfiltersettings/{numberFilterSetting}', 'App\Http\Controllers\Admin\NumberFilterSettingsController@update');
            Route::delete('/admin/numberfiltersettings/{numberFilterSetting}/delete', 'App\Http\Controllers\Admin\NumberFilterSettingsController@remove');
        });
        /**
        * Settings
        */
        Route::get('/admin/settings', 'App\Http\Controllers\Admin\SettingsController@index');
        Route::group(['middleware' => ['App\Http\Middleware\ReportNotRunning']], function () {
            Route::post('/admin/settings', 'App\Http\Controllers\Admin\SettingsController@update');
        });
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout');
    });


});
