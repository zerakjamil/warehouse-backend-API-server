<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BranchResource;
use App\Http\Resources\V1\DeviceResource;
use App\Http\Resources\V1\WarehouseResource;
use App\Models\V1\Branch;
use App\Models\V1\Device;
use App\Models\V1\Warehouse;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::with('branches')->paginate();

        return WarehouseResource::collection($warehouses);
    }

    public function showBranches(Warehouse $warehouse)
    {
        $branches = Branch::where('warehouse_id',$warehouse->id)->get();
        return BranchResource::collection($branches);
    }

    public function showDevices(Warehouse $warehouse)
    {
        $devices = Device::where('warehouse_id',$warehouse->id)->get();
        return DeviceResource::collection($devices);
    }
}
