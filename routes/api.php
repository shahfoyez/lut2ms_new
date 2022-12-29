<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\VehicleLocationController;

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

// Public routes
Route::controller(VehicleLocationController::class)->group(function () {
    Route::get('/routes', 'index');
    Route::get('/route/vehicles/{route}', 'routeVehicles');
    // Route::get('/trip/vehicles', 'tripVehicles');

    Route::get('/vehicles/location', 'vehiclesLocation');
    Route::get('/vehicle/locationUpdate/{vid}/{long}/{lat}', 'store');
});
Route::controller(ChatController::class)->group(function () {
    Route::post('/message/send', 'store');
});
Route::controller(ApiController::class)->group(function () {
    Route::get('/notices', 'notices');
    Route::get('/schedule', 'schedule');
});

// Protected routes
// Route::group( ['middleware' => ['auth:sanctum']], function () {
//     Route::controller(LocationUpdateController::class)->group(function () {
//         Route::get('/routes', 'index');
//         Route::post('/locationUpdate/{vid}/{long}/{lat}/{status}', 'store');
//     });
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
