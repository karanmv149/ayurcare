<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SignalingMessage extends Model
{
    protected $fillable = [
        'consultation_id',
        'sender_id',
        'type',
        'payload',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
