<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class OAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Update OAuth details
            $user->oauth_provider = 'google';
            $user->oauth_id = $googleUser->getId();
            $user->save();

            Auth::login($user);
            return redirect('/home');
        } else {
            // Create new user
            $user = new User();
            $user->name = $googleUser->getName();
            $user->email = $googleUser->getEmail();
            $user->oauth_provider = 'google';
            $user->oauth_id = $googleUser->getId();
            $user->save();

            // Redirect to role selection page
            return redirect()->route('auth.select-role.view')->with('user_id', $user->id);
        }
    }

    public function selectRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:patient,doctor',
        ]);

        $user = User::find($request->user_id);
        $user->role = $request->role;
        $user->save();

        Auth::login($user);

        return match ($user->role) {
            'doctor' => redirect()->route('doctor.dashboard'),
            'patient' => redirect()->route('patient.dashboard'),
            default => redirect('/'),
        };
    }
}