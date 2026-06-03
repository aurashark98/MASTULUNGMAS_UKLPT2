<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ServiceCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'category_id');
    }
}
