<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\BranchController;
use App\Http\Controllers\API\V1\DeviceController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (){
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);


    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/user', [UserController::class,'getUserInfo']);
        Route::apiResource('/warehouses', WarehouseController::class);
        Route::apiResource('/branches', BranchController::class);
        Route::get('/warehouses/{warehouse}/branches', [WarehouseController::class,'showBranches']);
        Route::get('/warehouses/{warehouse}/devices', [WarehouseController::class,'showDevices']);
        Route::get('/devices/search', [DeviceController::class,'search']);


//    Route::get('branches/{branch}', [BranchController::class, 'show']);
//    Route::apiResource('warehouses.branches', BranchController::class)->only('index');
//    Route::apiResource('warehouses.devices', DeviceController::class)->only('index');
//
//    Route::get('devices/search', [DeviceController::class, 'search'])->name('devices.search');
//    Route::get('devices/{device}/status', [DeviceController::class, 'getStatus'])->name('devices.status');

    });
});

