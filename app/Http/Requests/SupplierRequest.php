<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $supplierId = $this->route('supplier');
        return [
            'name'      => 'required|string|max:255|unique:suppliers,name,' . $supplierId,
            'email'     => 'nullable|email|max:255',
            'phone'     => 'required|nullable|string|max:20',
            'address'   => 'nullable|string|max:255',
            'note'      => 'nullable|string|max:500',
            'is_active' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Vui lòng nhập tên nhà cung cấp.',
            'name.unique' => 'Tên nhà cung cấp đã tồn tại.',
            'name.max'           => 'Tên nhà cung cấp không được vượt quá 255 ký tự.',
            'name.string'        => 'Tên nhà cung cấp phải là chuỗi.',

            'email.required'      => 'Vui lòng nhập email nhà cung cấp.',
            'email.email'        => 'Email không đúng định dạng.',
            'email.max'          => 'Email không được vượt quá 255 ký tự.',

            'phone.required'      => 'Vui lòng nhập số điện thoại nhà cung cấp.',
            'phone.max'          => 'Số điện thoại không được vượt quá 10 ký tự.',
            'phone.string'       => 'Số điện thoại phải là chuỗi.',

            'address.required'      => 'Vui lòng nhập địa chỉ nhà cung cấp.',
            'address.max'        => 'Địa chỉ không được vượt quá 255 ký tự.',
            'address.string'     => 'Địa chỉ phải là chuỗi.',

            'note.required'      => 'Vui lòng nhập ghi chú nhà cung cấp.',
            'note.max'           => 'Ghi chú không được vượt quá 500 ký tự.',
            'note.string'        => 'Ghi chú phải là chuỗi.',

            'is_active.required' => 'Vui lòng chọn trạng thái.',
            'is_active.in'       => 'Trạng thái không hợp lệ.',
        ];
    }
}
