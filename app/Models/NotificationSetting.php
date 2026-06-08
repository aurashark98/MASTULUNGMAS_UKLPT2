<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'email_enabled',
        'database_enabled',
    ];

    protected $casts = [
        'email_enabled' => 'boolean',
        'database_enabled' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all available notification types.
     */
    public static function availableTypes(): array
    {
        return [
            'new_bid' => 'Penawaran Baru',
            'bid_accepted' => 'Penawaran Diterima',
            'task_assigned' => 'Tugas Ditugaskan',
            'task_completed' => 'Tugas Selesai',
            'payment_received' => 'Pembayaran Diterima',
            'new_review' => 'Ulasan Baru',
            'verification_status' => 'Status Verifikasi Mitra',
        ];
    }
}
