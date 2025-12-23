<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarePlan extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'title',
        'duration_days',
        'daily_routine',
        'diet_guidelines',
        'lifestyle_advice',
    ];
}
