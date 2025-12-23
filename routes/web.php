<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DoctorVerificationController;
use App\Http\Controllers\Admin\DoctorApprovalController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\CarePlanController;
use App\Http\Controllers\PatientProfileController;

/*
|--------------------------------------------------------------------------
| Public Root
|--------------------------------------------------------------------------
*/
Route::view('/', 'welcome')->name('welcome');

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Post-Login Redirect (SINGLE SOURCE OF TRUTH)
|--------------------------------------------------------------------------
*/
Route::get('/home', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();

    return match ($user->role) {
        'admin'   => redirect()->route('admin.doctors'),
        'doctor'  => redirect()->route('doctor.dashboard'),
        'patient' => redirect()->route('patient.dashboard'),
        default   => abort(403),
    };
})->middleware('auth')->name('home');

/*
|--------------------------------------------------------------------------
| Doctor Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->group(function () {

    Route::get('/dashboard', fn () => view('doctor.dashboard'))
        ->name('doctor.dashboard');

    Route::get('/verify', [DoctorVerificationController::class, 'show'])
        ->name('doctor.verify');

    Route::post('/verify', [DoctorVerificationController::class, 'store'])
        ->name('doctor.verify.store');

    Route::get('/patients/{patient}/consultation', [ConsultationController::class, 'create'])
        ->name('doctor.consultation.create');

    Route::post('/patients/{patient}/consultation', [ConsultationController::class, 'store'])
        ->name('doctor.consultation.store');

    Route::get('/patients/{patient}/care-plan', [CarePlanController::class, 'create'])
        ->name('doctor.careplan.create');

    Route::post('/patients/{patient}/care-plan', [CarePlanController::class, 'store'])
        ->name('doctor.careplan.store');
});

/*
|--------------------------------------------------------------------------
| Patient Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:patient'])->prefix('patient')->group(function () {

    Route::get('/dashboard', fn () => view('patient.dashboard'))
        ->name('patient.dashboard');

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
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    Route::get('/doctors', [DoctorApprovalController::class, 'index'])
        ->name('admin.doctors');

    Route::post('/doctors/{doctor}/approve', [DoctorApprovalController::class, 'approve'])
        ->name('admin.doctors.approve');

    Route::post('/doctors/{doctor}/reject', [DoctorApprovalController::class, 'reject'])
        ->name('admin.doctors.reject');
});
