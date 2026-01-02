<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if (! $request->user()->hasVerifiedEmail()) {
            $request->user()->markEmailAsVerified();
            event(new Verified($request->user()));
        }

        return match ($request->user()->role) {
            'admin'   => redirect()->route('admin.doctors', ['verified' => 1]),
            'doctor'  => redirect()->route('doctor.dashboard', ['verified' => 1]),
            'patient' => redirect()->route('patient.dashboard', ['verified' => 1]),
            default   => redirect('/'),
        };
    }
}
