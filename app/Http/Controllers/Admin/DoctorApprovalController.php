<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorProfile;

class DoctorApprovalController extends Controller
{
    public function index()
    {
        $doctors = DoctorProfile::with('user')->where('status', 'pending')->get();
        return view('admin.doctors.index', compact('doctors'));
    }

    public function approve(DoctorProfile $doctor)
    {
        $doctor->update(['status' => 'verified']);
        return back()->with('success', 'Doctor approved');
    }

    public function reject(DoctorProfile $doctor)
    {
        $doctor->update(['status' => 'rejected']);
        return back()->with('success', 'Doctor rejected');
    }
}
