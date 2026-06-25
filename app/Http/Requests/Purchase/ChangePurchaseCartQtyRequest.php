<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class ChangePurchaseCartQtyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'raw_material_id' => 'required|exists:raw_materials,id',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'raw_material_id.required' => __('Raw material is required'),
            'raw_material_id.exists' => __('Raw material not found'),
            'quantity.required' => __('Quantity is required'),
            'quantity.integer' => __('Quantity must be a number'),
            'quantity.min' => __('Quantity must be at least 1'),
        ];
    }
}