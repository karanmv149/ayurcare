<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DoctorVerificationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\DoctorApprovalController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\CarePlanController;
use App\Http\Controllers\PatientProfileController;
use App\Http\Controllers\DoctorProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorDashboardController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\VideoConsultationController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', function () {
    $doctors = app(DoctorController::class)->getVerifiedDoctors(6);
    return view('welcome', compact('doctors'));
})->name('welcome');

// Public doctors listing (IMPORTANT: keep order)
Route::get('/doctors', [DoctorController::class, 'index'])
    ->name('doctors.index');

Route::get('/doctors/{id}', [DoctorController::class, 'show'])
    ->name('doctors.show');

// Patient booking route
Route::post('/doctors/{doctor}/book', [ConsultationController::class, 'book'])
    ->middleware('auth')
    ->name('doctors.book');

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze)
|--------------------------------------------------------------------------
| Note: auth.php handles its own middleware grouping:
| - Guest routes (login, register, etc.) are wrapped in 'guest' middleware
| - Authenticated routes (logout, password update, etc.) are wrapped in 'auth' middleware
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| OAuth Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('auth/google', [OAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [OAuthController::class, 'handleGoogleCallback']);
    Route::get('auth/select-role', function () {
        return view('auth.select-role');
    })->name('auth.select-role.view');
    Route::post('auth/select-role', [OAuthController::class, 'selectRole'])->name('auth.select-role');
});

/*
|--------------------------------------------------------------------------
| Post-Login Redirect (Single Source of Truth)
|--------------------------------------------------------------------------
*/
Route::get('/home', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    return match (Auth::user()->role) {
        'admin' => redirect()->route('admin.doctors'),
        'doctor' => redirect()->route('doctor.dashboard'),
        'patient' => redirect()->route('patient.dashboard'),
        default => abort(403),
    };
})->middleware('auth')->name('home');

/*
|--------------------------------------------------------------------------
| Booking Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});

/*
|--------------------------------------------------------------------------
| Message Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/bookings/{booking}/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/bookings/{booking}/messages', [MessageController::class, 'store'])->name('messages.store');
});

/*
|--------------------------------------------------------------------------
| Video Consultation Routes (Shared)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/consultations/{consultation}/video', [VideoConsultationController::class, 'show'])
        ->name('consultations.video');

    Route::post('/consultations/{consultation}/start', [VideoConsultationController::class, 'start'])
        ->name('consultations.video.start');

    Route::post('/consultations/{consultation}/end', [VideoConsultationController::class, 'end'])
        ->name('consultations.video.end');

    Route::post('/consultations/{consultation}/signal', [VideoConsultationController::class, 'sendSignal'])
        ->name('consultations.video.signal');

    Route::get('/consultations/{consultation}/signals', [VideoConsultationController::class, 'getSignals'])
        ->name('consultations.video.signals');
});

/*
|--------------------------------------------------------------------------
| Doctor Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:doctor'])
    ->prefix('doctor')
    ->group(function () {

        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])
            ->name('doctor.dashboard');

        Route::get('/profile/edit', [DoctorProfileController::class, 'edit'])
            ->name('doctor.profile.edit');

        Route::post('/profile', [DoctorProfileController::class, 'update'])
            ->name('doctor.profile.update');

        Route::get('/verify', [DoctorVerificationController::class, 'show'])
            ->name('doctor.verify');

        Route::post('/verify', [DoctorVerificationController::class, 'store'])
            ->name('doctor.verify.store');

        Route::get('/patients/{patient}/consultation', [ConsultationController::class, 'create'])
            ->name('doctor.consultation.create');

        Route::post('/patients/{patient}/consultation', [ConsultationController::class, 'store'])
            ->name('doctor.consultation.store');

        // Consultation requests from patients
        Route::get('/consultations/{consultation}', [ConsultationController::class, 'show'])
            ->name('doctor.consultation.show');

        Route::post('/consultations/{consultation}/respond', [ConsultationController::class, 'respond'])
            ->name('doctor.consultation.respond');

        Route::post('/consultations/{consultation}/start', [ConsultationController::class, 'start'])
            ->name('doctor.consultation.start');

        Route::post('/availability', [DoctorProfileController::class, 'updateAvailability'])
            ->name('doctor.availability.update');

        Route::get('/patients/{patient}/care-plan', [CarePlanController::class, 'create'])
            ->name('doctor.careplan.create');

        Route::post('/patients/{patient}/care-plan', [CarePlanController::class, 'store'])
            ->name('doctor.careplan.store');

        // Booking management
        Route::post('/bookings/{booking}/approve', [BookingController::class, 'approve'])
            ->name('bookings.approve');

        Route::post('/bookings/{booking}/reject', [BookingController::class, 'reject'])
            ->name('bookings.reject');

        Route::post('/queue/next', [QueueController::class, 'next'])
            ->name('doctor.queue.next');
    });

/*
|--------------------------------------------------------------------------
| Patient Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:patient'])
    ->prefix('patient')
    ->group(function () {

        Route::get('/dashboard', [PatientProfileController::class, 'dashboard'])
            ->name('patient.dashboard');

        Route::get('/profile/edit', [PatientProfileController::class, 'edit'])
            ->name('patient.profile.edit');

        Route::post('/profile', [PatientProfileController::class, 'update'])
            ->name('patient.profile.update');

        Route::get('/consultations', [PatientProfileController::class, 'consultations'])
            ->name('patient.consultations');

        Route::get('/care-plans', [PatientProfileController::class, 'carePlans'])
            ->name('patient.careplans');
    });

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        // Admin landing = doctors approval list
        Route::get('/doctors', [DoctorApprovalController::class, 'index'])
            ->name('admin.doctors');

        Route::post('/doctors/{doctor}/approve', [DoctorApprovalController::class, 'approve'])
            ->name('admin.doctors.approve');

        Route::post('/doctors/{doctor}/reject', [DoctorApprovalController::class, 'reject'])
            ->name('admin.doctors.reject');
    });
