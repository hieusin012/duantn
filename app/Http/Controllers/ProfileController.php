<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'fullname' => 'required|string|max:199',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'phone' => ['nullable', 'regex:/^(0)(3|5|7|8|9)[0-9]{8}$/'],
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Nam,Nữ,Khác',
            'birthday' => 'nullable|date',
            'language' => 'nullable|string|max:50',
            'introduction' => 'nullable|string',
            ], [
            'phone.regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập đúng định dạng Việt Nam như 0901234567.',
            ]);
        $data = $request->except('avatar');

            if (!empty($data['phone'])) {
            $data['phone'] = preg_replace('/[^0-9+]/', '', $data['phone']);      // loại ký tự không phải số
            $data['phone'] = preg_replace('/^\+84/', '0', $data['phone']);       // chuyển +84 về 0
            }
       $user->fill($data);  

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }
        $user->save();
        return redirect()->route('profile.show')->with('success', 'Cập nhật hồ sơ thành công!');
    }
}


