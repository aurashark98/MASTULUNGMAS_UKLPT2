<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerPortfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'title',
        'description',
        'image_path',
        'completed_date',
    ];

    protected $casts = [
        'completed_date' => 'date',
    ];

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }
}
