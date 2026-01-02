<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $doctor = User::findOrFail($request->doctor_id);

        if (!$doctor->isDoctor()) {
            return back()->withErrors(['error' => 'Invalid doctor selected.']);
        }

        if (auth()->id() === $doctor->id) {
            return back()->withErrors(['error' => 'You cannot book a consultation with yourself.']);
        }

        if (!auth()->user()->isPatient()) {
            return back()->withErrors(['error' => 'Only patients can create bookings.']);
        }

        Booking::create([
            'doctor_id' => $doctor->id,
            'patient_id' => auth()->id(),
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Booking request sent successfully.');
    }

    public function approve(Booking $booking)
    {
        if ($booking->doctor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if (!$booking->doctor->isDoctor()) {
            return back()->withErrors(['error' => 'Only doctors can approve bookings.']);
        }

        $booking->update(['status' => 'approved']);

        // Check if already in queue (idempotency)
        $exists = \App\Models\Queue::where('booking_id', $booking->id)->exists();

        if (!$exists) {
            // Get last position for this doctor today
            // Note: Simplification - considering one queue per doctor regardless of day, 
            // or we could filter by today created_at. 
            // The prompt asks for "Today's queue list". 
            // We'll queue them for "Now" effectively.

            $maxPosition = \App\Models\Queue::where('doctor_id', $booking->doctor_id)
                ->whereIn('status', ['waiting', 'in_progress'])
                ->max('position');

            \App\Models\Queue::create([
                'doctor_id' => $booking->doctor_id,
                'patient_id' => $booking->patient_id,
                'booking_id' => $booking->id,
                'status' => 'waiting',
                'position' => $maxPosition ? $maxPosition + 1 : 1,
            ]);
        }

        return back()->with('success', 'Booking approved and added to queue.');
    }

    public function reject(Booking $booking)
    {
        if ($booking->doctor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if (!$booking->doctor->isDoctor()) {
            return back()->withErrors(['error' => 'Only doctors can reject bookings.']);
        }

        $booking->update(['status' => 'rejected']);

        return back()->with('success', 'Booking rejected.');
    }
}
