<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class ForgetPasswordController extends Controller
{
    // Hiển thị form quên mật khẩu
    public function showForgotPassword()
    {
        return view('auth.password');
    }

    // Xử lý gửi link reset mật khẩu
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users,email'
            ],
            [
                'email.required' => 'Vui lòng nhập email.',
                'email.email' => 'Email không đúng định dạng.',
                'email.exists' => 'Email không tồn tại trong hệ thống.',
            ]
        );

        $status = Password::sendResetLink(
            $request->only('email')
        );
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }
        return back()->withErrors(['email' => __($status)]);
    }
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset', ['token' => $token, 'email' => $request->email]);
    }
    // Xử lý reset mật khẩu
    public function resetPassword(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'confirmed', PasswordRule::min(6)->mixedCase()->numbers()],
                'token' => ['required']
            ],
            [
                'email.required' => 'Vui lòng nhập địa chỉ email.',
                'email.email' => 'Địa chỉ email không đúng định dạng.',

                'password.required' => 'Vui lòng nhập mật khẩu mới.',
                'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
                'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
                'password.mixed' => 'Mật khẩu phải bao gồm cả chữ hoa và chữ thường.',
                'password.numbers' => 'Mật khẩu phải chứa ít nhất một chữ số.',

                'token.required' => 'Thiếu mã xác thực đặt lại mật khẩu.',
            ]
        );


        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
