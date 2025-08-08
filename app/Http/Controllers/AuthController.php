<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        ]);

        // Kiểm tra tài khoản bị khóa
        $user = \App\Models\User::where('email', $request->email)->first();
        // if ($user && $user->status === 'inactive') {
        if ($user && $user->status !== 'active') {
            return back()->withErrors([
                'email' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ hỗ trợ.',
            ]);
        }

        // Giới hạn 5 lần đăng nhập sai
        $throttleKey = strtolower($request->input('email')) . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Bạn đã vượt quá số lần thử. Vui lòng thử lại sau " . ceil($seconds / 60) . " phút.",
            ]);
        }

        if (Auth::attempt($credentials)) {
            RateLimiter::clear($throttleKey); // Reset đếm nếu login đúng
            $request->session()->regenerate();

            // Kiểm tra role admin hoặc user
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin')->with('success', 'Đăng nhập thành công');
            } else {
                return redirect('/')->with('success', 'Đăng nhập thành công');
            }
        }
        RateLimiter::hit($throttleKey, 900); // Đếm sai, 900 giây = 15 phút

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    // Hiển thị form đăng ký (dành cho người dùng bình thường)
    public function showRegister()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        $data = $request->validate([
            'fullname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ỹ\s]+$/u'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ],

        ], [
            'fullname.required' => 'Vui lòng nhập tên.',
            'fullname.string' => 'Tên không hợp lệ.',
            'fullname.max' => 'Tên không được vượt quá 255 ký tự.',
            'fullname.regex' => 'Tên chỉ được chứa chữ cái và khoảng trắng.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 20 ký tự.',
            'password.regex' => 'Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt.',
        ]);

        User::create([
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'member',
            'status' => 'active', // Thêm dòng này
        ]);

        // Không login, mà redirect về login
        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }


    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login')->with('success', 'Bạn đã đăng xuất tài khoản');
    }
    
}
