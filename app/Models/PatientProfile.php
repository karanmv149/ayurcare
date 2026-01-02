<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientProfile extends Model
{
    protected $fillable = [
        'user_id',
        'age',
        'gender',
        'diet_type',
        'sleep_quality',
        'stress_level',
        'digestion',
        'primary_concern',
        'vata',
        'pitta',
        'kapha',
        'dominant_prakriti',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
