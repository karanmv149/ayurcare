<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    protected $fillable = [
    'user_id',
    'qualification',
    'registration_number',
    'experience_years',
    'clinic_name',
    'certificate_path',
    'status',
];

public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

}
