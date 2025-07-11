<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Hoặc thêm phân quyền nếu cần
    }

    public function rules(): array
    {
        return [
            'supplier_id' => 'required|exists:suppliers,id',
            'note' => 'nullable|string|max:1000',
            'products' => 'required|array|min:1',
            'products.*.variant_id' => 'required|exists:product_variants,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'supplier_id.required' => 'Vui lòng chọn nhà cung cấp.',
            'supplier_id.exists' => 'Nhà cung cấp không hợp lệ.',
            'products.required' => 'Vui lòng thêm ít nhất một sản phẩm.',
            'products.*.variant_id.required' => 'Vui lòng chọn biến thể sản phẩm.',
            'products.*.variant_id.exists' => 'Biến thể sản phẩm không tồn tại.',
            'products.*.quantity.required' => 'Vui lòng nhập số lượng.',
            'products.*.quantity.min' => 'Số lượng tối thiểu là 1.',
            'products.*.price.required' => 'Vui lòng nhập giá nhập.',
            'products.*.price.min' => 'Giá nhập phải lớn hơn hoặc bằng 0.',
        ];
    }
}
