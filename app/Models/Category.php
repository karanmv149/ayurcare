<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];
    public function doctors()
    {
        return $this->hasMany(\App\Models\DoctorProfile::class);
    }

}
