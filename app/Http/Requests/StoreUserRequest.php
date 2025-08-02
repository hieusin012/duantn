<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    {
        return [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            // 'password' => 'required|min:6|confirmed',
            'avatar' => 'nullable|image|max:2048',
            'phone' => ['nullable', 'regex:/^(0)(3|5|7|8|9)[0-9]{8}$/'],
            'address' => 'nullable|string',
            'role' => 'required|in:member,admin',
            // 'status' => 'required|boolean',
            'status' => 'required|in:active,inactive',
            'gender' => 'nullable|in:Nam,Nữ,Khác',
            'birthday' => 'nullable|date',
            'language' => 'nullable|string',
            'introduction' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'fullname.required' => 'Họ và tên không được để trống.',
            'fullname.string' => 'Họ và tên phải là chuỗi ký tự.',
            'fullname.max' => 'Họ và tên không được vượt quá 255 ký tự.',

            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã được sử dụng.',

            'password.required' => 'Mật khẩu không được để trống.',
            // 'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',

            'avatar.image' => 'Ảnh đại diện phải là file hình ảnh.',
            'avatar.max' => 'Ảnh đại diện không được lớn hơn 2MB.',

            'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phone.regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập đúng định dạng Việt Nam như 0901234567.',

            'address.string' => 'Địa chỉ phải là chuỗi ký tự.',

            'role.required' => 'Vai trò không được để trống.',
            'status.required' => 'Trạng thái không được để trống.',

            'role.in' => 'Vai trò không hợp lệ. Chỉ chấp nhận member hoặc admin.',

            // 'status.boolean' => 'Trạng thái không hợp lệ.',
            'status.in' => 'Trạng thái không hợp lệ. Chỉ chấp nhận Hoạt động hoặc Tạm khóa.',

            'gender.in' => 'Giới tính không hợp lệ. Chỉ chấp nhận Nam, Nữ hoặc Khác.',

            'birthday.date' => 'Ngày sinh không hợp lệ.',

            'language.string' => 'Ngôn ngữ phải là chuỗi ký tự.',

            'introduction.string' => 'Giới thiệu phải là chuỗi ký tự.',
        ];
    }
}
