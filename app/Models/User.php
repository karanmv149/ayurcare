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
        'oauth_provider',
        'oauth_id',
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

// Reviews relationships
public function reviewsAsDoctor()
{
    return $this->hasMany(Review::class, 'doctor_id');
}

public function reviewsAsPatient()
{
    return $this->hasMany(Review::class, 'patient_id');
}

// Accessors
public function getAverageRatingAttribute()
{
    return $this->reviewsAsDoctor()->avg('rating') ?? 0;
}

public function getReviewsCountAttribute()
{
    return $this->reviewsAsDoctor()->count();
}

// Booking relationships
public function doctorBookings()
{
    return $this->hasMany(Booking::class, 'doctor_id');
}

public function patientBookings()
{
    return $this->hasMany(Booking::class, 'patient_id');
}

// Message relationships
public function sentMessages()
{
    return $this->hasMany(Message::class, 'sender_id');
}

public function receivedMessages()
{
    return $this->hasMany(Message::class, 'receiver_id');
}

    
}
