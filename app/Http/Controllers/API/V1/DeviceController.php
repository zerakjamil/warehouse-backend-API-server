<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreDeviceRequest;
use App\Http\Requests\V1\UpdateDeviceRequest;
use App\Http\Resources\V1\DeviceResource;
use App\Jobs\ImportDevicesJob;
use App\Models\V1\Device;
use App\Models\V1\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all();

        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' indexed all available devices');

        return DeviceResource::collection($devices);
    }

    public function show(Device $device)
    {
        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' read a device under id: ' .$device->id);
        return new DeviceResource($device);
    }

    public function update(UpdateDeviceRequest $request,Device $device)
    {
        $device->update($request->all());
        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' updated a device under id: ' .$device->id);
        return new DeviceResource($device);
    }

    public function store(StoreDeviceRequest $request)
    {
        $device = Device::create($request->all());
        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' created a device');
        return new DeviceResource($device);
    }

    public function destroy(Device $device)
    {
        $device->delete();

        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' deleted a device');

        return response()->json([
            'status' => 'success',
            'message' => 'Device deleted successfully'
        ]);
    }
    public function search(Request $request)
    {
        $query = $request->input('q');
        $devices = Device::when($query,function ($queryBuilder) use ($query) {
            $queryBuilder->where('serial_number', 'like', '%' . $query . '%')->orWhere('mac_address', 'like', '%' . $query . '%');
        })->paginate();
        return DeviceResource::collection($devices);
    }

    public function export()
    {
        $devices = Device::all();
        $filename = 'devices.csv';
        $filePath = storage_path('app/public/' . $filename);

        $file = fopen($filePath, 'w');

        fputcsv($file, ['ID', 'Serial Number', 'MAC Address', 'Branch ID', 'Registered At', 'Sold At', 'Box Number']);

        foreach ($devices as $device) {
            fputcsv($file, [
                $device->id,
                $device->serial_number,
                $device->mac_address,
                $device->branch_id,
                $device->registered_at,
                $device->sold_at,
                $device->box_number,
            ]);
        }

        fclose($file);

        return response()->download($filePath, $filename, ['Content-Type' => 'text/csv']);
    }

    public function import()
    {
        $filePath = storage_path('app/public/devices.csv'); // Updated the file path

        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        ImportDevicesJob::dispatch($filePath)->onQueue('imports');

        return response()->json(['message' => 'Import job dispatched'], 200);
    }

    public function assignToWarehouse(UpdateDeviceRequest $request,Device $device)
    {
        $warehouse = Warehouse::find($request->warehouseId);
        if ($warehouse){
            $device->update([
                'warehouse_id' => $request->warehouseId
            ]);
            return new DeviceResource($device);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'warehouse not found'
        ]);
    }
}
