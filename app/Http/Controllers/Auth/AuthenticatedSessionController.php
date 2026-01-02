<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();

        // Ensure user is instance of User
        if (!$user) {
            return redirect()->route('login')->with('error', 'Authentication failed.');
        }

        // Direct Role Handling
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.doctors', absolute: false));
        } elseif ($user->role === 'doctor') {
            return redirect()->intended(route('doctor.dashboard', absolute: false));
        } elseif ($user->role === 'patient') {
            return redirect()->intended(route('patient.dashboard', absolute: false));
        }

        return redirect('/');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }



}
