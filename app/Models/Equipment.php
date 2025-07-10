<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_per_day',
        'stock',
        'brand',
        'model',
        'manufacture_year',
        'specifications',
        'images',
        'category_id',
        'is_active'
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
        'images' => 'array',
        'specifications' => 'array',
        'is_active' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function getFirstImageAttribute()
    {
        return $this->images ? $this->images[0] : null;
    }

    public function getSpecificationsArrayAttribute()
    {
        // Get the raw specifications attribute to avoid infinite recursion
        $specifications = $this->attributes['specifications'] ?? null;
        
        if (!$specifications) {
            return [];
        }
        
        // If specifications is stored as JSON string, decode it
        if (is_string($specifications)) {
            $decodedSpecs = json_decode($specifications, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decodedSpecs)) {
                return $decodedSpecs;
            }
            
            // If it's not JSON, treat as text format and convert to array
            $specs = [];
            $lines = explode("\n", $specifications);
            
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line && strpos($line, ':') !== false) {
                    $parts = explode(':', $line, 2);
                    if (count($parts) === 2) {
                        $specs[trim($parts[0])] = trim($parts[1]);
                    }
                }
            }
            
            return $specs;
        }
        
        // If it's already an array, return it
        if (is_array($specifications)) {
            return $specifications;
        }
        
        return [];
    }

    public function isAvailableForPeriod($startDate, $endDate)
    {
        $conflictingBookings = $this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                          ->where('end_date', '>=', $endDate);
                    });
            })
            ->count();

        return $conflictingBookings < $this->stock;
    }
}
