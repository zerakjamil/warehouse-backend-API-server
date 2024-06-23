<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateBranchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!Auth::user()->isSuperAdmin()){
            return false;
        }
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
            'name' => ['required','sometimes','string','max:255'],
            'profileLogo' => ['required','sometimes','string'],
            'address' => ['required','sometimes','string'],
            'warehouseId' => ['required','sometimes','integer']
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'profile_logo' => $this->profileLogo,
            'warehouse_id' => $this->warehouseId
        ]);
    }
}
