<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return match ($request->user()->role) {
                'admin'   => redirect()->route('admin.doctors'),
                'doctor'  => redirect()->route('doctor.dashboard'),
                'patient' => redirect()->route('patient.dashboard'),
                default   => redirect('/'),
            };
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
