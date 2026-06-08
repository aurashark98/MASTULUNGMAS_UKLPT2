<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

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
        'profile_photo_path',
    ];

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

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
        return $this->hasMany(ChatRoom::class, $this->role === 'user' ? 'user_id' : 'mitra_id');
    }

    public function portfolios()
    {
        return $this->hasMany(PartnerPortfolio::class, 'partner_id');
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

    public function sendNotification($type, $title, $message, $url = null)
    {
        return \Illuminate\Support\Facades\DB::table('notifications')->insert([
            'id' => \Illuminate\Support\Str::uuid(),
            'type' => 'App\Notifications\MTMNotification',
            'notifiable_type' => 'App\Models\User',
            'notifiable_id' => $this->id,
            'data' => json_encode([
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'url' => $url,
            ]),
            'read_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
