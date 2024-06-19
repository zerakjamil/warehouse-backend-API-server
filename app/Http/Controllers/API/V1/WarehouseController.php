<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateWarehouseRequest;
use App\Http\Resources\V1\BranchResource;
use App\Http\Resources\V1\DeviceResource;
use App\Http\Resources\V1\WarehouseResource;
use App\Models\V1\Branch;
use App\Models\V1\Device;
use App\Models\V1\Warehouse;
use http\Env\Response;
use Illuminate\Http\Request;
class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::with('branches')->paginate();

        return WarehouseResource::collection($warehouses);
    }

    public function show(Request $request,Warehouse $warehouse)
    {
        $includeBranches = $request->query('includeBranches');

        if ($includeBranches){
            return new WarehouseResource($warehouse->loadMissing('branches'));
        }

        return new WarehouseResource($warehouse);
    }

    public function update(UpdateWarehouseRequest $request,Warehouse $warehouse)
    {
        $warehouse->update($request->all());
        return new WarehouseResource($warehouse);
    }

    public function store(Request $request)
    {
        return new WarehouseResource(Warehouse::create($request->all()));
    }
    public function destroy(Request $request,Warehouse $warehouse)
    {
        $warehouse->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'warehouse deleted successfully'
        ]);
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
