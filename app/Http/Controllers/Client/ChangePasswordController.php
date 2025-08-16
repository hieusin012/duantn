<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use App\Models\User;

class ChangePasswordController extends Controller
{
    // Hiển thị form đổi mật khẩu
    public function showChangePasswordForm()
    {
        return view('profile.change-password');
    }

    // Xử lý đổi mật khẩu
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'different:current_password', PasswordRule::min(6)->mixedCase()->numbers(), 'confirmed'],
            'new_password_confirmation' => ['required', 'string'],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_password_confirmation.required' => 'Vui lòng xác nhận mật khẩu mới.',
            'new_password.different' => 'Mật khẩu mới phải khác mật khẩu hiện tại.',
            'new_password.confirmed' => 'Mật khẩu mới và xác nhận không khớp.',
        ]);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->route('profile.show')->with('success', 'Đổi mật khẩu thành công!');
    }
}
