<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
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
        'phone_number',
        'username',
        'address',
    ];

    /**
     * Relationships
     */
    public function mitraProfile()
    {
        return $this->hasOne(MitraProfile::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function bids()
    {
        return $this->hasMany(TaskBid::class, 'mitra_id');
    }

    public function assignments()
    {
        return $this->hasMany(TaskAssignment::class, 'mitra_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'mitra_id');
    }

    public function chatRooms()
    {
        return $this->role === 'mitra' 
            ? $this->hasMany(ChatRoom::class, 'mitra_id') 
            : $this->hasMany(ChatRoom::class, 'user_id');
    }

    /**
     * Role checks
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isMitra()
    {
        return $this->role === 'mitra';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
