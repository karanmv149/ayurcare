<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
	'role',
    ];
    
public function isDoctor(): bool
{
    return $this->role === 'doctor';
}

public function isPatient(): bool
{
    return $this->role === 'patient';
}

public function isAdmin(): bool
{
    return $this->role === 'admin';
}
public function doctorProfile()
{
    return $this->hasOne(\App\Models\DoctorProfile::class);
}
public function isVerifiedDoctor(): bool
{
    return $this->isDoctor()
        && $this->doctorProfile
        && $this->doctorProfile->status === 'verified';
}
public function patientProfile()
{
    return $this->hasOne(\App\Models\PatientProfile::class);
}

    
}
