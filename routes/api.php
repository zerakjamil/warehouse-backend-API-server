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

    Route::middleware(['auth:sanctum','super-admin','rate-limiter'])->group(function () {
        Route::get('/user', [UserController::class,'getUserInfo']);
        Route::apiResource('/warehouses', WarehouseController::class);
        Route::apiResource('/branches', BranchController::class);
        Route::get('/warehouses/{warehouse}/branches', [WarehouseController::class,'showBranches']);
        Route::get('/warehouses/{warehouse}/devices', [WarehouseController::class,'showDevices']);
        Route::get('/devices/search', [DeviceController::class,'search']);
        Route::get('/devices/export', [DeviceController::class,'export']);
        Route::patch('devices/{device}/assign', [DeviceController::class,'assignToWarehouse']);
        Route::post('/devices/import', [DeviceController::class, 'import']);
    });
});

