<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientProfile;

class PatientProfileEditController extends Controller
{
    public function show()
    {
        $profile = auth()->user()->patientProfile ?? null;
        
        return view('patient.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'nullable|string',
            'diet_type' => 'nullable|string',
            'sleep_quality' => 'nullable|string',
            'stress_level' => 'nullable|string',
            'digestion' => 'nullable|string',
        ]);

        if ($request->name !== auth()->user()->name) {
            auth()->user()->update(['name' => $request->name]);
        }

        $vata = 0;
        $pitta = 0;
        $kapha = 0;

        if (($data['sleep_quality'] ?? null) === 'light') $vata += 2;
        if (($data['stress_level'] ?? null) === 'high') $vata += 2;
        if (($data['digestion'] ?? null) === 'strong') $pitta += 2;
        if (($data['diet_type'] ?? null) === 'spicy') $pitta += 2;
        if (($data['sleep_quality'] ?? null) === 'deep') $kapha += 2;
        if (($data['diet_type'] ?? null) === 'heavy') $kapha += 2;

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
            ->route('patient.profile.edit')
            ->with('success', 'Profile updated successfully');
    }
}
