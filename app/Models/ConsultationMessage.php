<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationMessage extends Model
{
    protected $fillable = [
        'consultation_id',
        'sender_id',
        'body',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function isFromDoctor()
    {
        return $this->consultation->doctor_id === $this->sender_id;
    }

    public function isFromPatient()
    {
        return $this->consultation->patient_id === $this->sender_id;
    }
}
