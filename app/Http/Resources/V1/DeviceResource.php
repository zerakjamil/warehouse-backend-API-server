<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'serialNumber'  => $this->serial_number,
            'macAddress' => $this->mac_address,
            'branchId' => $this->branch->id,
            'warehouseId' => $this->warehouse->id,
            'registeredAt' => $this->registered_at,
            'soldDate' => $this->sold_at,
            'boxNumber' => $this->box_number,
        ];
    }
}
