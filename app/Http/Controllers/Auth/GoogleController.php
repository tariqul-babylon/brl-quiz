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
            [
                'email' => $googleUser->getEmail()
            ],
            [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'email_verified_at' => now(),               
                'google_avater' => $googleUser->getAvatar(),
                'google_id' => $googleUser->getId(),
            ]
        );
        //check if created or updated
        if ($user->wasRecentlyCreated) {
            $user->update([
                'register_method' => 2,
            ]);
        }

        Auth::login($user);

        return redirect()->intended('/exams'); 
    }
}
