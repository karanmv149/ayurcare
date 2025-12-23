<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CarePlan;
use Illuminate\Http\Request;

class CarePlanController extends Controller
{
    public function create(User $patient)
    {
        return view('doctor.careplan.create', compact('patient'));
    }

    public function store(Request $request, User $patient)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'duration_days' => 'required|integer|min:1',
            'daily_routine' => 'nullable|string',
            'diet_guidelines' => 'nullable|string',
            'lifestyle_advice' => 'nullable|string',
        ]);

        CarePlan::create([
            'doctor_id' => auth()->id(),
            'patient_id' => $patient->id,
            ...$data,
        ]);

        return redirect()->route('doctor.dashboard')->with('success', 'Care plan assigned');
    }
}
