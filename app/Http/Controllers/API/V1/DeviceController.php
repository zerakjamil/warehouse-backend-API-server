<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DeviceResource;
use App\Models\V1\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use SplTempFileObject;

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
}
