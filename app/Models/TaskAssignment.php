<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskAssignment extends Model
{
    protected $fillable = [
        'task_id',
        'mitra_id',
        'assigned_at',
        'completed_at',
        'evidence_path',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'completed_at' => 'datetime',
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
