<?php

namespace App\Http\Controllers;

use App\Models\DoctorProfile;
use Illuminate\Http\Request;

class DoctorVerificationController extends Controller
{
    public function show()
    {
        $profile = auth()->user()->doctorProfile;
        return view('doctor.verify', compact('profile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'qualification' => 'required|string|max:255',
            'registration_number' => 'required|string|max:255',
            'experience_years' => 'nullable|string|max:50',
            'clinic_name' => 'nullable|string|max:255',
            'certificate' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $path = $request->file('certificate')->store('certificates', 'public');

        DoctorProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'qualification' => $request->qualification,
                'registration_number' => $request->registration_number,
                'experience_years' => $request->experience_years,
                'clinic_name' => $request->clinic_name,
                'certificate_path' => $path,
                'status' => 'pending',
            ]
        );

        return redirect()->back()->with('success', 'Verification submitted. Await admin approval.');
    }
}
