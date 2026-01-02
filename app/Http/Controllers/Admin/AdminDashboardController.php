<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Consultation;
use App\Models\CarePlan;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'total_users' => User::count(),
            'total_doctors' => User::where('role', 'doctor')->count(),
            'verified_doctors' => User::where('role', 'doctor')
                ->whereHas('doctorProfile', fn($q) => $q->where('is_verified', true))
                ->count(),
            'bookings_today' => \App\Models\Booking::whereDate('created_at', today())->count(),
            'pending_approvals' => User::where('role', 'doctor')
                ->whereHas('doctorProfile', fn($q) => $q->where('is_verified', false)->where('status', 'submitted')) // Assuming 'submitted' is the status for pending
                ->count(),
            'total_patients' => User::where('role', 'patient')->count(),
            'total_consultations' => Consultation::count(),
            'total_care_plans' => CarePlan::count(),
            'total_reviews' => Review::count(),
        ];

        return view('admin.dashboard', compact('metrics'));
    }
}
