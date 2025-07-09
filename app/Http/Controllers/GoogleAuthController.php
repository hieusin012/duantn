<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $email = $googleUser->getEmail();

        if (!str_ends_with($email, '@gmail.com')) {
            abort(403, 'Không được phép đăng nhập');
        }
        $avatarUrl = $googleUser->getAvatar();
        $filename = uniqid() . '.jpg';
        $path = 'avatars/' . $filename;
        Storage::disk('public')->put($path, file_get_contents($avatarUrl));
        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'fullname' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $path,
                'password' => bcrypt(uniqid())
            ]
        );
        if ($user->wasRecentlyCreated) {
            Mail::to($email)->send(new WelcomeMail($user));
        }
        Log::info('Gửi mail tới: ' . $user->email);
        Auth::login($user);

        return redirect()->intended('/');
    }
}
