<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;

class Queue extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'booking_id',
        'status',
        'position',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
