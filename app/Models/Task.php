<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'budget',
        'location',
        'images',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
        'budget' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function bids()
    {
        return $this->hasMany(TaskBid::class);
    }

    public function assignment()
    {
        return $this->hasOne(TaskAssignment::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function chatRoom()
    {
        return $this->hasOne(ChatRoom::class);
    }
}
