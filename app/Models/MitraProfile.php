<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MitraProfile extends Model
{
    protected $fillable = [
        'user_id',
        'ktp_path',
        'profile_photo_path',
        'skills',
        'bio',
        'is_verified',
        'is_online',
        'latitude',
        'longitude',
        'rating',
        'earnings',
        'service_area',
        'service_radius',
        'operational_hours',
        'portfolio_images',
    ];

    protected $casts = [
        'skills' => 'array',
        'is_verified' => 'boolean',
        'is_online' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
        'rating' => 'decimal:2',
        'earnings' => 'decimal:2',
        'portfolio_images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
