<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DeviceResource;
use App\Jobs\ImportDevicesJob;
use App\Models\V1\Device;
use Illuminate\Http\Request;


class DeviceController extends Controller
{

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

    public function import(Request $request)
    {
        $filePath = 'C:\laragon\www\hr\storage\devices.csv';

        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        // Dispatch the job to import devices
        ImportDevicesJob::dispatch($filePath)->onQueue('imports');

        return response()->json(['message' => 'Import job dispatched'], 200);
    }
}
