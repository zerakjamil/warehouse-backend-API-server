<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBranchRequest extends FormRequest
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
            'name' => ['required','string','max:255'],
            'profileLogo' => ['required','string'],
            'address' => ['required','string'],
            'warehouse_id' => ['required','integer']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'profile_logo' => $this->profileLogo,
        ]);
    }
}
