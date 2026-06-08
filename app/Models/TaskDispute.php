<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskDispute extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'reporter_id',
        'reported_user_id',
        'reason',
        'description',
        'evidence_path',
        'partner_evidence_path',
        'partner_response',
        'status',
        'resolution',
        'resolved_by',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function getEvidenceUrlAttribute()
    {
        return $this->evidence_path ? asset('storage/' . $this->evidence_path) : null;
    }

    public function getPartnerEvidenceUrlAttribute()
    {
        return $this->partner_evidence_path ? asset('storage/' . $this->partner_evidence_path) : null;
    }
}
