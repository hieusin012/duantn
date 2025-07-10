<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            $email = $facebookUser->getEmail() ?? $facebookUser->getId() . '@facebook.local';

            $user = User::where('facebook_id', $facebookUser->getId())->first();

            if (!$user) {
                $user = User::create([
                    'fullname'     => $facebookUser->getName(),
                    'email'        => $email,
                    'facebook_id'  => $facebookUser->getId(),
                    'password'     => bcrypt(Str::random(16)),
                ]);
            }
            Auth::login($user);
            return redirect()->route('client.home')->with('success', 'Đăng nhập thành công');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Đăng nhập bằng Facebook thất bại.']);
        }
    }
}
