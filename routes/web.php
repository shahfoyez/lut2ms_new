<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FuelController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MeterController;
use App\Http\Controllers\RoutexController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\StoppageController;
use App\Http\Controllers\MaintenanceController;

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
Route::get('/landing', function(){
    return view('landing');
});
Route::get('/location', function(){
    return view('location');
});
Route::get('/dateR', function(){
    return view('daterangepicker');
});

// Route::get('/tests', function(){
//     return view('tests');
// });
Route::middleware(['guest'])->group(function () {
    Route::controller(SessionController::class)->group(function () {
        Route::get('/', 'loginCreate')->name('login');
        Route::post('/createAccount', 'createAccount');
        Route::post('/session', 'check');
    });
});
// auth Middleware Group
Route::middleware(['auth'])->group(function () {
    // GeneralController Group
    Route::controller(GeneralController::class)->group(function () {
        Route::get('/dashboard', 'index');
        // Route::get('/vehicleByRoute/{rout}', 'vehicleByRoute');
    });

    // UserController Group
    Route::controller(UserController::class)->group(function () {
        Route::get('/user/users', 'show');
        Route::get('/user/add', 'create');
        Route::post('/user/add', 'store');
        Route::get('/user/edit/{user}', 'edit');
        Route::post('/user/update/{user}', 'Update');
        Route::delete('/user/delete/{user}', 'destroy');

        Route::get('/user/profile/{user}', 'profile');
    });

    // EmployeeController Group
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/employee/employees', 'create');
        Route::get('/employee/employeeAdd', 'employeeAdd');
        Route::post('/employee/employeeAdd', 'store');
        Route::get('/employee/departments', 'departments');
        Route::get('/employee/designations', 'designations');
        Route::get('/employee/departmentAdd', 'departmentCreate');
        Route::get('/employee/designationAdd', 'designationCreate');
        Route::post('/employee/departmentAdd', 'departmentAdd');
        Route::post('/employee/designationAdd', 'designationAdd');
        // Employee EUD
        Route::get('/employee/employeeEdit/{employee}', 'edit');
        Route::post('/employee/employeeUpdate/{employee}', 'update');
        Route::delete('/employee/employeeDelete/{employee}', 'destroy');
        // Department EUD
        Route::get('/employee/departmentEdit/{department}', 'departmentEdit');
        Route::post('/employee/departmentUpdate/{department}', 'departmentUpdate');
        Route::get('/employee/designationEdit/{designation}', 'designationEdit');
        // Designation EUD
        Route::post('/employee/designationUpdate/{designation}', 'designationUpdate');
        Route::delete('/employee/designationDelete/{designation}', 'designationDestroy');
        Route::delete('/employee/departmentDelete/{department}', 'departmentDestroy');
    });

    // RouteManagementController Group
    Route::controller(RoutexController::class)->group(function () {
        Route::get('/route/routes', 'create');
        Route::get('/route/routeAdd', 'routeAdd');
        Route::post('/route/routeAdd', 'store');
        // Route EUD
        Route::get('/route/routeEdit/{route}', 'edit');
        Route::post('/route/routeUpdate/{route}', 'update');
        Route::delete('/route/routeDelete/{route}', 'destroy');
    });

    // StoppageManagementController Group
    Route::controller(StoppageController::class)->group(function () {
        Route::get('/route/stoppages', 'create');
        Route::get('/route/stoppageAdd', 'stopageAdd');
        Route::post('/route/stopageAdd', 'store');
        // Stoppage EUD
        Route::get('/route/stoppageEdit/{stoppage}', 'edit');
        Route::post('/route/stoppageUpdate/{stoppage}', 'update');
        Route::delete('/route/stoppageDelete/{stoppage}', 'destroy');
    });

    // VehicleManagementController Group
    Route::controller(VehicleController::class)->group(function () {
        Route::get('/vehicle/vehicles', 'create');
        Route::get('/vehicle/vehicleAdd', 'vehicleAdd');
        Route::post('/vehicle/vehicleAdd', 'store');
        Route::get('/requisition/vehicles', 'reqVehicles');
        // Route::get('/requisition/send/{vehicle}', 'vehicleCreate');
        // Route::post('/requisition/vehicleSend', 'vehicleSend');
        // Route::get('/requisition/reach/{vehicle}', 'vehicleReach');
        // Route::get('/requisition/cancel/{vehicle}', 'vehicleCancel');
        // Vehicle EUD
        Route::get('/vehicle/vehicleEdit/{vehicle}', 'edit');
        Route::post('/vehicle/vehicleUpdate/{vehicle}', 'update');
        Route::delete('/vehicle/vehicleDelete/{vehicle}', 'destroy');

        // Vehicle type
        Route::get('/vehicle/vehicleTypes', 'vehicleTypes');
        Route::get('/vehicle/typeAdd', 'typeAdd');
        Route::post('/vehicle/typeAdd', 'typeStore');
        // Vehicle type EDU
        Route::get('/vehicle/typeEdit/{type}', 'typeEdit');
        Route::post('/vehicle/typeUpdate/{type}', 'typeUpdate');
        Route::delete('/vehicle/typeDelete/{type}', 'typeDestroy');

        // Filter
        Route::get('/vehicle/vehicles/filter', 'filter');
    });

    // TripController Group
     Route::controller(TripController::class)->group(function () {
        Route::get('/requisition/vehicles', 'reqVehicles');
        Route::get('/requisition/send/{vehicle}', 'vehicleCreate');
        Route::post('/requisition/vehicleSend', 'vehicleSend');
        Route::get('/requisition/reach/{vehicle}', 'vehicleReach');
        Route::get('/requisition/cancel/{vehicle}', 'vehicleCancel');

        Route::get('/trip/history', 'show');
        Route::get('/vehicleTrip/history/{vehicle}', 'vehicleTrips');

        Route::get('/requisition/edit/{trip}', 'edit');
        Route::post('/requisition/update/{trip}', 'update');
        Route::delete('/requisition/delete/{trip}', 'destroy');

        // Filter
        Route::get('/requisition/vehicles/filter', 'filter');
        Route::get('/trip/history/filter', 'tripFilter');


    });

    // FuelController Group
    Route::controller(FuelController::class)->group(function () {
        Route::get('/fuel/fuelVehicles', 'index');
        Route::get('/fuel/fuelRecords', 'show');
        Route::get('/fuel/fuelAdd/{vehicle}', 'create');
        Route::post('/fuel/fuelAdd', 'store');

        Route::get('/fuel/vehicleFuels/{vehicle}', 'vehicleFuels');

        Route::get('/fuel/edit/{fuel}', 'edit');
        Route::post('/fuel/fuelUpdate/{fuel}', 'update');
        Route::delete('/fuel/fuelDelete/{fuel}', 'destroy');

        // Filter
        Route::get('/fuel/fuelVehicles/filter', 'filter');
        Route::get('/fuel/fuelRecords/filter', 'fuelRecordsfilter');
    });

    // MeterController Group
    Route::controller(MeterController::class)->group(function () {
        Route::get('/meter/meterVehicles', 'index');
        Route::get('/meter/meterEntries', 'show');
        Route::get('/meter/meterEntryAdd/{vehicle}', 'create');
        Route::post('/meter/meterEntryAdd', 'store');

        Route::get('/meter/vehicleMeterEntries/{vehicle}', 'vehicleMeterEntries');

        Route::get('/meter/edit/{meter}', 'edit');
        Route::post('/meter/update/{meter}', 'update');
        Route::delete('/meter/meterDelete/{meter}', 'destroy');

        // Filter
        Route::get('/meter/meterVehicles/filter', 'meterVehicleFilter');
        Route::get('/meter/meterEntries/filter', 'meterEntriesFilter');



    });

    // MaintenanceController Group
    Route::controller(MaintenanceController::class)->group(function () {
        Route::get('/maintenance/maintenanceVehicles', 'index');
        Route::get('/maintenance/maintenanceRecords', 'show');
        Route::get('/maintenance/maintenanceAdd/{vehicle}', 'create');
        Route::post('/maintenance/maintenanceEntryAdd', 'store');
    });

    // ReminderController Group
    Route::controller(ReminderController::class)->group(function () {
        Route::get('/reminder/reminders', 'index');
        Route::get('/reminder/reminderAdd', 'create');
        Route::post('/reminder/reminderAdd', 'store');

        // new added
        Route::get('/reminder/edit/{reminder}', 'edit');
        Route::post('/reminder/update/{reminder}', 'update');
        Route::delete('/reminder/delete/{reminder}', 'destroy');
    });

    // logout
    Route::post('/logout', [SessionController::class, 'destroy']);
});
