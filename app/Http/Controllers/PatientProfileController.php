<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientProfile;
use App\Models\Consultation;
use App\Models\CarePlan;

class PatientProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Patient Intake Form
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $queueItem = \App\Models\Queue::where('patient_id', auth()->id())
            ->whereIn('status', ['waiting', 'in_progress'])
            ->with('doctor')
            ->orderBy('created_at', 'desc')
            ->first();

        $activeVideoConsultation = Consultation::where('patient_id', auth()->id())
            ->whereIn('video_status', ['scheduled', 'in_progress'])
            ->whereNotNull('doctor_id')
            ->latest() // Safest to get the most recent one
            ->first();

        return view('patient.dashboard', compact('queueItem', 'activeVideoConsultation'));
    }

    public function show()
    {
        $profile = auth()->user()->patientProfile ?? null;

        return view('patient.intake', compact('profile'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store / Update Patient Profile
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $data = $request->validate([
            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'nullable|string',
            'diet_type' => 'nullable|string',
            'sleep_quality' => 'nullable|string',
            'stress_level' => 'nullable|string',
            'digestion' => 'nullable|string',
        ]);

        // Prakriti scoring (simple & safe)
        $vata = 0;
        $pitta = 0;
        $kapha = 0;

        if (($data['sleep_quality'] ?? null) === 'light')
            $vata += 2;
        if (($data['stress_level'] ?? null) === 'high')
            $vata += 2;

        if (($data['digestion'] ?? null) === 'strong')
            $pitta += 2;
        if (($data['diet_type'] ?? null) === 'spicy')
            $pitta += 2;

        if (($data['sleep_quality'] ?? null) === 'deep')
            $kapha += 2;
        if (($data['diet_type'] ?? null) === 'heavy')
            $kapha += 2;

        $dominant = collect([
            'vata' => $vata,
            'pitta' => $pitta,
            'kapha' => $kapha,
        ])->sortDesc()->keys()->first();

        PatientProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            array_merge($data, [
                'vata' => $vata,
                'pitta' => $pitta,
                'kapha' => $kapha,
                'dominant_prakriti' => ucfirst($dominant),
            ])
        );

        return redirect()
            ->route('patient.dashboard')
            ->with('success', 'Profile saved successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | Patient Consultation History (READ ONLY)
    |--------------------------------------------------------------------------
    */
    public function consultations()
    {
        $consultations = Consultation::where('patient_id', auth()->id())
            ->latest()
            ->get();

        return view('patient.consultations', compact('consultations'));
    }

    /*
    |--------------------------------------------------------------------------
    | Patient Care Plans (READ ONLY)
    |--------------------------------------------------------------------------
    */
    public function carePlans()
    {
        $carePlans = CarePlan::where('patient_id', auth()->id())
            ->latest()
            ->get();

        return view('patient.careplans', compact('carePlans'));
    }

    public function edit()
    {
        $profile = auth()->user()->patientProfile;

        return view('patient.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'nullable|string|in:male,female,other',
            'primary_concern' => 'nullable|string|max:1000',
        ]);

        $profile = auth()->user()->patientProfile;

        if (!$profile) {
            $profile = new PatientProfile(['user_id' => auth()->id()]);
        }

        $profile->update($request->only([
            'age',
            'gender',
            'primary_concern',
        ]));

        return back()->with('success', 'Profile updated successfully.');
    }
}
