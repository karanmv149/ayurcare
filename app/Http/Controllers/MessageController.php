<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Booking;

class MessageController extends Controller
{
    public function index(Booking $booking)
    {
        // Ensure the user belongs to the booking
        if (auth()->id() !== $booking->doctor_id && auth()->id() !== $booking->patient_id) {
            abort(403, 'Unauthorized');
        }

        $messages = $booking->messages()->with('sender')->orderBy('created_at')->get();

        return view('messages.index', compact('booking', 'messages'));
    }

    public function store(Request $request, Booking $booking)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Ensure the booking is approved
        if ($booking->status !== 'approved') {
            return back()->withErrors(['error' => 'Messaging is only allowed for approved bookings.']);
        }

        // Ensure the sender belongs to the booking
        if (auth()->id() !== $booking->doctor_id && auth()->id() !== $booking->patient_id) {
            abort(403, 'Unauthorized');
        }

        // Determine receiver
        $receiver_id = (auth()->id() === $booking->doctor_id) ? $booking->patient_id : $booking->doctor_id;

        Message::create([
            'booking_id' => $booking->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $receiver_id,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Message sent.');
    }
}
