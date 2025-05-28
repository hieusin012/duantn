<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cho phép truy cập, nếu có phân quyền thì xử lý tại đây
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'color_id' => 'required|integer|exists:colors,id',
            'size_id' => 'required|integer|exists:sizes,id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
