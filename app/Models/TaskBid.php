<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskBid extends Model
{
    protected $fillable = [
        'task_id',
        'mitra_id',
        'bid_amount',
        'message',
        'status',
    ];

    protected $casts = [
        'bid_amount' => 'decimal:2',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function mitra()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }
}
