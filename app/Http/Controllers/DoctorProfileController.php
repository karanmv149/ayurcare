<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorProfile;
use App\Models\Category;

class DoctorProfileController extends Controller
{
    public function edit()
    {
        $profile = auth()->user()->doctorProfile;
        $categories = Category::all();

        return view('doctor.profile.edit', compact('profile', 'categories'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'bio' => 'nullable|string|max:1000',
            'category_id' => 'required|exists:categories,id',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'consultation_fee' => 'nullable|integer|min:0',
            'clinic_name' => 'nullable|string|max:255',
        ]);

        $profile = auth()->user()->doctorProfile;

        if (!$profile) {
            return back()->withErrors(['error' => 'Doctor profile not found.']);
        }

        $profile->update($request->only([
            'bio',
            'category_id',
            'experience_years',
            'consultation_fee',
            'clinic_name',
        ]));

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updateAvailability(Request $request)
    {
        $request->validate([
            'availability' => 'required|in:available,busy,offline',
        ]);

        $profile = auth()->user()->doctorProfile;

        if ($profile) {
            $profile->update(['availability' => $request->availability]);
        }

        return back()->with('success', 'Availability status updated.');
    }
}