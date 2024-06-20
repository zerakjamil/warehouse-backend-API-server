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

        Route::apiResource('/branches', BranchController::class);
        Route::apiResource('/devices', DeviceController::class);
        Route::apiResource('/warehouses', WarehouseController::class);

        Route::prefix('/warehouses')->group(function (){
            Route::get('{warehouse}/branches', [WarehouseController::class,'showBranches']);
            Route::get('{warehouse}/devices', [WarehouseController::class,'showDevices']);
        });

        Route::prefix('/devices')->group(function (){
            Route::get('search', [DeviceController::class,'search']);
            Route::get('export', [DeviceController::class,'export']);
            Route::patch('{device}/assign', [DeviceController::class,'assignToWarehouse']);
            Route::post('import', [DeviceController::class, 'import']);
        });
    });
});

