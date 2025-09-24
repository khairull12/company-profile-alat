<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    
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
        // Get the specifications attribute
        $specifications = $this->specifications;
        
        if (!$specifications) {
            return [];
        }
        
        // If already an array, return it
        if (is_array($specifications)) {
            return $specifications;
        }
        
        // If it's a string, try to decode as JSON
        if (is_string($specifications)) {
            $decodedSpecs = json_decode($specifications, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decodedSpecs)) {
                return $decodedSpecs;
            }
            
            // If not JSON, treat as text and convert to array
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
        
        return [];
    }

    public function getSpecificationsAttribute($value)
    {
        if (!$value) {
            return [];
        }
        
        // Try to decode JSON
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }
        
        return is_array($value) ? $value : [];
    }

    /**
     * Decrease the equipment stock by the specified quantity
     * 
     * @param int $quantity
     * @return bool
     * @throws \Exception
     */
    public function decreaseStock(int $quantity = 1): bool
    {
        if ($this->stock < $quantity) {
            throw new \Exception('Insufficient stock available');
        }

        return $this->update([
            'stock' => $this->stock - $quantity
        ]);
    }

    /**
     * Increase the equipment stock by the specified quantity
     * 
     * @param int $quantity
     * @return bool
     */
    public function increaseStock(int $quantity = 1): bool
    {
        return $this->update([
            'stock' => $this->stock + $quantity
        ]);
    }

    /**
     * Check if the equipment has sufficient stock
     * 
     * @param int $quantity
     * @return bool
     */
    public function hasStock(int $quantity = 1): bool
    {
        return $this->stock >= $quantity;
    }
}
