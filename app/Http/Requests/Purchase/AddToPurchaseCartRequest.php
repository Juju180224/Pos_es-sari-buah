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
            'kode_produk' => 'required|string|exists:produk,kode_produk',
        ];
    }

    public function messages(): array
    {
        return [
            'barcode.required' => __('Barcode is required'),
            'barcode.exists' => __('Product not found with this barcode'),
        ];
    }
}
