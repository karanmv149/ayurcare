<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'qualification',
        'registration_number',
        'experience_years',
        'clinic_name',
        'bio',
        'certificate_path',
        'status',
        'is_verified',
        'availability',
    ];

    public function getAvailabilityColorAttribute()
    {
        return match ($this->availability) {
            'available' => 'green',
            'busy' => 'red',
            'offline' => 'gray',
            default => 'gray',
        };
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }


}
