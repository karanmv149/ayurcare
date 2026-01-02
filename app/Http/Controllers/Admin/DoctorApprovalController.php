<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorProfile;

class DoctorApprovalController extends Controller
{
    public function index()
    {
        // Get all doctors with their profiles
        $allDoctors = \App\Models\User::where('role', 'doctor')
            ->whereHas('doctorProfile')
            ->with(['doctorProfile.category'])
            ->latest()
            ->get();

        // Separate into pending and approved
        $pendingDoctors = $allDoctors->filter(function ($doctor) {
            return !$doctor->doctorProfile || !$doctor->doctorProfile->is_verified;
        });

        $approvedDoctors = $allDoctors->filter(function ($doctor) {
            return $doctor->doctorProfile && $doctor->doctorProfile->is_verified;
        });

        return view('admin.doctors.index', compact('pendingDoctors', 'approvedDoctors'));
    }


    public function approve(\App\Models\User $doctor)
    {
        if (!$doctor->doctorProfile) {
            return back()->with('error', 'Doctor profile not found.');
        }

        $doctor->doctorProfile->update([
            'is_verified' => true,
            'status' => 'verified',
        ]);

        // Refresh the relationship to ensure updated data is available
        $doctor->load('doctorProfile');

        return back()->with('success', 'Doctor approved successfully.');
    }

    public function reject(\App\Models\User $doctor)
    {
        if (!$doctor->doctorProfile) {
            return back()->with('error', 'Doctor profile not found.');
        }

        $doctor->doctorProfile->update([
            'is_verified' => false,
            'status' => 'rejected',
        ]);

        // Refresh the relationship to ensure updated data is available
        $doctor->load('doctorProfile');

        return back()->with('success', 'Doctor rejected.');
    }


}
