<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\SuperAdmin;
use Illuminate\Support\Facades\Route;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/token/create', [AuthController::class,'createToken']);


Route::middleware('auth:sanctum')->group(function () {

    //Protected Area

    Route::get('/user', [UserController::class,'getUserInfo'])->middleware([SuperAdmin::class]);

//    Route::apiResource('warehouses', WarehouseController::class)
//        ->middleware('can:superadmin');
//
//    Route::get('branches/{branch}', [BranchController::class, 'show']);
//    Route::apiResource('warehouses.branches', BranchController::class)->only('index');
//    Route::apiResource('warehouses.devices', DeviceController::class)->only('index');
//
//    Route::get('devices/search', [DeviceController::class, 'search'])->name('devices.search');
//    Route::get('devices/{device}/status', [DeviceController::class, 'getStatus'])->name('devices.status');

});
