<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'username' => Str::slug($googleUser->getName(), '_'),
                'email_verified_at' => now(),
                'password' => bcrypt(Str::random(24)),
                'photo' => $googleUser->getAvatar(),
            ]
        );

        Auth::login($user);

        return redirect()->intended('/dashboard'); // Change this to your desired landing page
    }
}
