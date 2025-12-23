<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function create(User $patient)
    {
        return view('doctor.consultation.create', compact('patient'));
    }

    public function store(Request $request, User $patient)
    {
        $data = $request->validate([
            'chief_complaint' => 'nullable|string',
            'assessment' => 'nullable|string',
            'recommendation' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Consultation::create([
            'doctor_id' => auth()->id(),
            'patient_id' => $patient->id,
            ...$data,
        ]);

        return redirect()->route('doctor.dashboard')->with('success', 'Consultation saved');
    }
}
