<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Lấy user hiện tại từ route param
        $userId = $this->route('user')->id;

        return [
            'fullname' => ['required', 'string', 'max:255', 'regex:/^[\p{L}\p{M}\s\'\-]+$/u', function ($attribute, $value, $fail) {
                if (stripos($value, '<script') !== false) {
                    $fail('Thông tin không hợp lệ. Họ tên không được chứa mã script.');
                }
            }],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => 'nullable|min:8|max:20|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'avatar' => 'nullable|image|max:2048',
            'phone' => ['nullable', 'regex:/^(\+84|0)\d{9,10}$/'],
            'address' => 'nullable|string',
            'role' => 'nullable|in:member,admin',
            // 'status' => 'nullable|boolean',
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
            'fullname.regex' => 'Họ tên không được chứa ký tự đặc biệt. Chỉ bao gồm chữ cái, khoảng trắng, gạch nối (-) hoặc dấu nháy đơn (\').',

            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã được sử dụng.',

            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 20 ký tự.',
            'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ hoa, một chữ thường, một số và một ký tự đặc biệt.',

            'avatar.image' => 'Ảnh đại diện phải là file hình ảnh.',
            'avatar.max' => 'Ảnh đại diện không được lớn hơn 2MB.',

            'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phone.regex' => 'Số điện thoại không hợp lệ. Ví dụ 10 số: 0333333333 hay 0888888888 hoặc 0901234567.',

            'address.string' => 'Địa chỉ phải là chuỗi ký tự.',

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
