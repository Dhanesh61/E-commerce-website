<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Illuminate\Http\Request;
use App\Models\User;   
use Illuminate\Support\Str; 

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Google authentication failed. Please try again.');
        }

        $existingUser = User::firstOrNew(['email' => $user->email]);

        if (!$existingUser->exists) {
            $existingUser->name = $user->name;
            $existingUser->password = bcrypt(Str::random(16));
            $existingUser->save();
        }

        $existingUser->email_verified_at = now();
        $existingUser->save();

        auth()->login($existingUser);

        return redirect()->route('home');
    }

}
