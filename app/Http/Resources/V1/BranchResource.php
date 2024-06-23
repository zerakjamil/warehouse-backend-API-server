<?php

namespace App\Http\Resources\V1;

use App\Models\V1\Device;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $remaining = Device::whereNull('sold_at')
            ->where('branch_id',$this->id)
            ->get();
        $sold = Device::whereNotNull('sold_at')
            ->where('branch_id',$this->id)
            ->get();

        return [
        'id' => $this->id,
        'name' => $this->name,
        'profileLogo' => $this->profile_logo,
        'address' => $this->address,
        'createdAt' => $this->created_at,
        'remainingDevices' => count($remaining),
        'soldDevices' => count($sold),
        'devices' => DeviceResource::collection($this->whenLoaded('devices')),
        ];
    }
}
