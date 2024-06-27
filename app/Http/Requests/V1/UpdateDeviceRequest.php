<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateDeviceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'serialNumber' => ['required','string','unique:devices,serial_number','max:10'],
            'macAddress' => ['required','string','unique:devices,mac_address','regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/'],
            'boxNumber' => ['required','string','unique:devices,box_number','regex:/^BOX-\d{5}$/'],
            'branchId' => ['required'],
            'registeredAt' => ['required','date'],
            'soldDate' => ['sometimes','required'],
            'warehouseId' => ['required'],
        ];
    }

    public function prepareForValidation()
    {
        if ($this->warehouseId){
            $this->merge([
                'warehouse_id' => $this->warehouseId,
                'mac_address' => $this->macAddress,
                'sold_date' => $this->soldDate,
                'serial_number' => $this->serialNumber,
                'branch_id' => $this->branchId,
                'registered_at' => $this->registeredAt,
                'box_number' => $this->boxNumber,
            ]);
        }
    }
}
