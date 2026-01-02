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

    public function book(Request $request, User $doctor)
    {
        // Route has auth middleware, so user is authenticated
        // Ensure user is a patient
        if (!auth()->user()->isPatient()) {
            abort(403, 'Only patients can book consultations.');
        }

        // Ensure target is a doctor
        if (!$doctor->isDoctor()) {
            abort(404, 'Doctor not found.');
        }

        // Ensure doctor has a profile
        if (!$doctor->doctorProfile) {
            return redirect()->route('doctors.show', $doctor->id)
                ->with('error', 'This doctor profile is not available for booking.');
        }

        // Prevent booking with yourself (edge case)
        if (auth()->id() === $doctor->id) {
            abort(403, 'You cannot book a consultation with yourself.');
        }

        $data = $request->validate([
            'chief_complaint' => 'required|string|max:1000|min:10',
        ], [
            'chief_complaint.required' => 'Please describe your symptoms or concerns.',
            'chief_complaint.min' => 'Please provide more details (at least 10 characters).',
            'chief_complaint.max' => 'Description is too long (maximum 1000 characters).',
        ]);

        Consultation::create([
            'doctor_id' => $doctor->id,
            'patient_id' => auth()->id(),
            'chief_complaint' => $data['chief_complaint'],
        ]);

        return redirect()->route('doctors.show', $doctor->id)
            ->with('success', 'Consultation request submitted successfully! The doctor will review your request.');
    }

    public function show(Consultation $consultation)
    {
        // Ensure the logged-in doctor owns this consultation
        if ($consultation->doctor_id !== auth()->id()) {
            abort(403, 'You do not have access to this consultation.');
        }

        // Load patient relationship
        $consultation->load('patient');

        return view('doctor.consultation.show', compact('consultation'));
    }

    public function respond(Request $request, Consultation $consultation)
    {
        // Ensure the logged-in doctor owns this consultation
        if ($consultation->doctor_id !== auth()->id()) {
            abort(403, 'You do not have access to this consultation.');
        }

        $data = $request->validate([
            'assessment' => 'nullable|string|max:5000',
            'recommendation' => 'nullable|string|max:5000',
            'notes' => 'nullable|string|max:5000',
        ]);

        $consultation->update($data);

        // Auto rule: When consultation ends -> availability = available
        if (auth()->user()->doctorProfile) {
            auth()->user()->doctorProfile->update(['availability' => 'available']);
        }

        return redirect()->route('doctor.dashboard')
            ->with('success', 'Consultation response saved successfully. You are now marked as Available.');
    }

    public function start(Consultation $consultation)
    {
        if ($consultation->doctor_id !== auth()->id()) {
            abort(403);
        }

        // Auto rule: When consultation starts -> availability = busy
        if (auth()->user()->doctorProfile) {
            auth()->user()->doctorProfile->update(['availability' => 'busy']);
        }

        return redirect()->route('doctor.consultation.show', $consultation->id)
            ->with('success', 'Consultation started. Status marked as Busy.');
    }
}
