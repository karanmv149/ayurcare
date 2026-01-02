<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\SignalingMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoConsultationController extends Controller
{
    public function show(Consultation $consultation)
    {
        $this->authorizeAccess($consultation);

        // If not started, doctor initiates. Patient waits.
        return view('consultations.video', compact('consultation'));
    }

    public function start(Consultation $consultation)
    {
        $this->authorizeAccess($consultation);

        if (Auth::user()->role === 'doctor') {
            $consultation->update([
                'video_status' => 'in_progress',
                'started_at' => now(),
            ]);
        }

        return response()->json(['status' => 'started']);
    }

    public function end(Consultation $consultation)
    {
        $this->authorizeAccess($consultation);

        $consultation->update([
            'video_status' => 'completed',
            'ended_at' => now(),
        ]);

        return response()->json(['status' => 'ended']);
    }

    public function sendSignal(Request $request, Consultation $consultation)
    {
        $this->authorizeAccess($consultation);

        SignalingMessage::create([
            'consultation_id' => $consultation->id,
            'sender_id' => Auth::id(),
            'type' => $request->type,
            'payload' => json_encode($request->payload),
        ]);

        return response()->json(['status' => 'sent']);
    }

    public function getSignals(Consultation $consultation)
    {
        $this->authorizeAccess($consultation);

        // Get messages not from me, created after 'after_id' if provided
        $query = SignalingMessage::where('consultation_id', $consultation->id)
            ->where('sender_id', '!=', Auth::id());

        if (request('after_id')) {
            $query->where('id', '>', request('after_id'));
        }

        $messages = $query->orderBy('id', 'asc')->get();

        return response()->json($messages);
    }

    private function authorizeAccess(Consultation $consultation)
    {
        if ($consultation->doctor_id !== Auth::id() && $consultation->patient_id !== Auth::id()) {
            abort(403, 'Unauthorized access to consultation.');
        }
    }
}
