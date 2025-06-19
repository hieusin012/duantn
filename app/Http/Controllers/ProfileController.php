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
            'phone' => 'nullable|string|max:11',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Nam,Nữ,Khác',
            'birthday' => 'nullable|date',
            'language' => 'nullable|string|max:50',
            'introduction' => 'nullable|string',
        ]);

        $user->fill($request->except('avatar'));

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


