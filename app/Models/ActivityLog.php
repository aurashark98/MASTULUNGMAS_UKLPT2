<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function log($action, $description = null, $userId = null)
    {
        $id = $userId ?? auth()->id();
        if ($id) {
            return self::create([
                'user_id' => $id,
                'action' => $action,
                'description' => $description,
            ]);
        }
        return null;
    }
}
