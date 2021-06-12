<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('phonecallevents', 'App\Http\Controllers\Api\PhoneCallEventsController@index');
Route::get('phonecallevents/{id}', 'App\Http\Controllers\Api\PhoneCallEventsController@show');
Route::post('phonecallevents', 'App\Http\Controllers\Api\PhoneCallEventsController@store');
Route::put('phonecallevents/{id}', 'App\Http\Controllers\Api\PhoneCallEventsController@update');
Route::delete('phonecallevents/{id}', 'App\Http\Controllers\Api\PhoneCallEventsController@delete');

Route::get('organisationunit', 'App\Http\Controllers\Api\OrganisationUnitsController@index');
Route::get('organisationunit/{id}', 'App\Http\Controllers\Api\OrganisationUnitsController@show');
Route::post('organisationunit', 'App\Http\Controllers\Api\OrganisationUnitsController@store');
Route::put('organisationunit/{id}', 'App\Http\Controllers\Api\OrganisationUnitsController@update');
Route::delete('organisationunit/{id}', 'App\Http\Controllers\Api\OrganisationUnitsController@delete');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
