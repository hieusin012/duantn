<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'required|max:200|unique:categories,name|regex:/^[a-zA-Z0-9\sÀ-ỹđĐ]+$/u',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            // 'image' => 'nullable|image',
            'image' => 'required|image',
            'is_active' => 'boolean',
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Trường tên danh mục là bắt buộc',
            'name.max' => 'Tên danh mục không được vượt quá 200 ký tự',
            'name.unique' => 'Tên danh mục đã tồn tại',
            'name.regex' => 'Tên danh mục không được chứa ký tự đặc biệt',
            'slug.unique' => 'Slug đã tồn tại',
            'slug.max' => 'Slug không được vượt quá 255 ký tự',
            'image.required' => 'Trường hình ảnh là bắt buộc',
            'image.image' => 'Trường hình ảnh phải là file ảnh',
            'is_active.boolean' => 'Trạng thái không hợp lệ',
            'parent_id.exists' => 'Danh mục cha không hợp lệ',
        ];
    }
}
