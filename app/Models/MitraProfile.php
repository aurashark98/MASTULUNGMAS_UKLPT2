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
        'rating',
        'earnings',
    ];

    protected $casts = [
        'skills' => 'array',
        'is_verified' => 'boolean',
        'is_online' => 'boolean',
        'rating' => 'decimal:2',
        'earnings' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
