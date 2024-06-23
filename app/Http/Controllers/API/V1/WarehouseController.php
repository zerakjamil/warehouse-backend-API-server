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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::with('branches')->paginate();
        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' indexed all the warehouses');
        return WarehouseResource::collection($warehouses);
    }

    public function show(Request $request,Warehouse $warehouse)
    {
        $includeBranches = $request->query('includeBranches');

        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' read warehouse under id: ' .$warehouse->id);

        if ($includeBranches){
            return new WarehouseResource($warehouse->loadMissing('branches'));
        }

        return new WarehouseResource($warehouse);
    }

    public function update(UpdateWarehouseRequest $request,Warehouse $warehouse)
    {
        $warehouse->update($request->all());
        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' updated a warehouse id: ' . $warehouse->id);
        return new WarehouseResource($warehouse);
    }

    public function store(Request $request)
    {
        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' created a new warehouse');
        return new WarehouseResource(Warehouse::create($request->all()));
    }
    public function destroy(Request $request,Warehouse $warehouse)
    {
        $warehouse->delete();
        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' deleted a warehouse under id: ' .$warehouse->id);
        return response()->json([
            'status' => 'success',
            'message' => 'warehouse deleted successfully'
        ]);
    }
    public function showBranches(Warehouse $warehouse)
    {
        $branches = Branch::where('warehouse_id',$warehouse->id)->get();
        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' read a warehouse\'s branches under id: ' .$warehouse->id);
        return BranchResource::collection($branches);
    }

    public function showDevices(Warehouse $warehouse)
    {
        $devices = Device::where('warehouse_id',$warehouse->id)->get();
        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' deleted a warehouse\'s devices under id: ' .$warehouse->id);
        return DeviceResource::collection($devices);
    }
}
