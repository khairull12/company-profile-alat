<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
