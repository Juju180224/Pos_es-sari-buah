<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class AddToPurchaseCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'raw_material_id' => 'required|integer|exists:raw_materials,id',
        ];
    }

    public function messages(): array
    {
        return [
            'raw_material_id.required' => __('Raw material is required'),
            'raw_material_id.exists' => __('Raw material not found'),
        ];
    }
}