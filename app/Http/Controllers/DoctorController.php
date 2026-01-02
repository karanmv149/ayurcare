<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        // Public listing: ONLY show verified doctors
        $query = User::where('role', 'doctor')
            ->whereHas('doctorProfile', function ($q) {
                $q->where('is_verified', true);
            })
            ->with(['doctorProfile.category'])
            ->withCount('reviewsAsDoctor as reviews_count')
            ->withAvg('reviewsAsDoctor as average_rating', 'rating');

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('doctorProfile.category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search filter
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        $doctors = $query->latest()->get();

        // Get all categories for filter dropdown
        $categories = \App\Models\Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('doctors.index', compact('doctors', 'categories'));
    }
    public function show($id)
    {
        // HARD GUARD: ensure scalar
        if (!is_numeric($id)) {
            abort(404);
        }

        // Public access: ONLY show verified doctors
        $doctor = \App\Models\User::where('id', (int) $id)
            ->where('role', 'doctor')
            ->whereHas('doctorProfile', function ($q) {
                $q->where('is_verified', true);
            })
            ->with('doctorProfile.category')
            ->firstOrFail();

        return view('doctors.show', compact('doctor'));
    }

    /**
     * Get verified doctors for landing page
     * Reuses the same query pattern as index() but only returns verified doctors
     */
    public function getVerifiedDoctors(int $limit = 6)
    {
        return User::where('role', 'doctor')
            ->whereHas('doctorProfile', function ($q) {
                $q->where('is_verified', true);
            })
            ->with(['doctorProfile.category'])
            ->latest()
            ->limit($limit)
            ->get();
    }



}
