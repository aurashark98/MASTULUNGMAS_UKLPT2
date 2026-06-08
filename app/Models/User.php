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

    public function favoritePartners()
    {
        return $this->belongsToMany(User::class, 'favorite_partners', 'user_id', 'partner_id')->withTimestamps();
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorite_partners', 'partner_id', 'user_id')->withTimestamps();
    }

    /**
     * Level System
     */
    public function getCompletedTasksCountAttribute()
    {
        return $this->assignments()->whereNotNull('completed_at')->count();
    }

    public function getLevelAttribute()
    {
        $count = $this->completed_tasks_count;
        if ($count > 100) return 'Platinum';
        if ($count > 50) return 'Gold';
        if ($count > 20) return 'Silver';
        return 'Bronze';
    }

    public function getLevelBadgeAttribute()
    {
        return match($this->level) {
            'Platinum' => 'bg-purple-100 text-purple-700 border-purple-200',
            'Gold' => 'bg-amber-100 text-amber-700 border-amber-200',
            'Silver' => 'bg-gray-100 text-gray-700 border-gray-200',
            default => 'bg-orange-100 text-orange-700 border-orange-200',
        };
    }

    public function isFavoriteOf($userId)
    {
        return $this->favoritedBy()->where('user_id', $userId)->exists();
    }

    /**
     * Scopes
     */
    public function scopeVerifiedMitra($query)
    {
        return $query->where('role', 'mitra')
            ->whereHas('mitraProfile', function($q) {
                $q->where('is_verified', true);
            });
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
