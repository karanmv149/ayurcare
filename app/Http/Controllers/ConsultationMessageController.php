<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\ConsultationMessage;

class ConsultationMessageController extends Controller
{
    public function store(Request $request, Consultation $consultation)
    {
        $this->authorizeAccess($consultation);

        $data = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        ConsultationMessage::create([
            'consultation_id' => $consultation->id,
            'sender_id' => auth()->id(),
            'body' => $data['body'],
        ]);

        return redirect()
            ->route('consultations.show', $consultation)
            ->with('success', 'Message sent successfully');
    }

    private function authorizeAccess(Consultation $consultation)
    {
        if (auth()->id() !== $consultation->patient_id && auth()->id() !== $consultation->doctor_id) {
            abort(403, 'Unauthorized access to this consultation');
        }
    }
}
