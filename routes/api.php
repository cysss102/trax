<?php

use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\TripController;
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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


//////////////////////////////////////////////////////////////////////////
/// Mock Endpoints To Be Replaced With RESTful API.
/// - API implementation needs to return data in the format seen below.
/// - Post data will be in the format seen below.
/// - /resource/assets/traxAPI.js will have to be updated to align with
///   the API implementation
//////////////////////////////////////////////////////////////////////////

Route::group(['middleware' => 'auth:api'], function () {
    //CarController:
    Route::get('cars', [
        CarController::class,
        'index',
    ]);
    Route::get('car/{car}', [
        CarController::class,
        'show',
    ]);
    Route::post('cars', [
        CarController::class,
        'store',
    ]);
    Route::delete('car/{car}', [
        CarController::class,
        'destroy',
    ]);

    //TripController:
    Route::get('trips', [
        TripController::class,
        'index',
    ]);
    Route::post('trips', [
        TripController::class,
        'store',
    ]);
});
