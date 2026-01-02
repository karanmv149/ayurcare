<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        $doctor = auth()->user();
        $doctor->load('doctorProfile');

        // Check if doctor is verified
        $isVerified = $doctor->doctorProfile && $doctor->doctorProfile->is_verified;

        // Only fetch consultations if doctor is verified
        $pendingConsultations = collect();
        $completedConsultations = collect();
        $queue = collect();

        if ($isVerified) {
            $doctorId = $doctor->id;

            // Fetch all consultations for this doctor, ordered by latest
            $allConsultations = Consultation::where('doctor_id', $doctorId)
                ->with(['patient'])
                ->latest()
                ->get();

            // Separate into pending and completed
            // Pending: consultation has no assessment, recommendation, or notes
            // Completed: consultation has at least one of assessment, recommendation, or notes
            $pendingConsultations = $allConsultations->filter(function ($consultation) {
                return empty($consultation->assessment)
                    && empty($consultation->recommendation)
                    && empty($consultation->notes);
            });

            $completedConsultations = $allConsultations->filter(function ($consultation) {
                return !empty($consultation->assessment)
                    || !empty($consultation->recommendation)
                    || !empty($consultation->notes);
            });

            // Fetch Queue
            $queue = \App\Models\Queue::where('doctor_id', $doctorId)
                ->whereIn('status', ['waiting', 'in_progress'])
                ->with('patient')
                ->orderBy('position')
                ->get();
        }

        return view('doctor.dashboard', compact('isVerified', 'pendingConsultations', 'completedConsultations', 'queue'));
    }
}

