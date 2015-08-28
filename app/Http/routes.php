<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');


Route::group(['prefix' => 'api/v1'], function () {
    Route::resource('makers', 'LessonsController', ['except' => ['create', 'edit']]);

    Route::resource('vehicles', 'VehicleController', ['only' => ['index']]);

    Route::resource('makers.vehicles', 'MakersVehicles', ['except' => ['edit', 'create']]);
});
