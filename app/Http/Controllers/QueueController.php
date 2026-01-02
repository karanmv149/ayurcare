<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;

class QueueController extends Controller
{
    public function next()
    {
        $doctor = auth()->user();
        if (!$doctor->isDoctor()) {
            abort(403);
        }

        // 1. Complete current in_progress
        $current = Queue::where('doctor_id', $doctor->id)
            ->where('status', 'in_progress')
            ->first();

        if ($current) {
            $current->update(['status' => 'completed']);
        }

        // 2. Start next waiting
        $next = Queue::where('doctor_id', $doctor->id)
            ->where('status', 'waiting')
            ->orderBy('position', 'asc')
            ->first();

        if ($next) {
            $next->update(['status' => 'in_progress']);
            return back()->with('success', 'Called next patient: ' . $next->patient->name);
        }

        return back()->with('info', 'Queue is empty.');
    }
}
