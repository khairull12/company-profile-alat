<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'equipment_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'company_name',
        'project_location',
        'start_date',
        'end_date',
        'duration_days',
        'project_description',
        'special_requirements',
        'rental_price',
        'total_price',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'rental_price' => 'decimal:2',
        'total_price' => 'decimal:2'
    ];

    // Relationships
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('created_at', now()->year);
    }

    // Accessors & Mutators  
    public function getBookingNumberAttribute()
    {
        return $this->booking_code;
    }

    public function getRentalCostAttribute()
    {
        return $this->rental_price * $this->duration_days;
    }

    public function getStatusBadge()
    {
        $statusClasses = [
            'pending' => 'bg-warning text-dark',
            'confirmed' => 'bg-info',
            'ongoing' => 'bg-success',
            'completed' => 'bg-primary',
            'cancelled' => 'bg-danger'
        ];

        $statusTexts = [
            'pending' => 'Pending',
            'confirmed' => 'Dikonfirmasi',
            'ongoing' => 'Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];

        $class = $statusClasses[$this->status] ?? 'bg-secondary';
        $text = $statusTexts[$this->status] ?? ucfirst($this->status);

        return "<span class=\"badge {$class}\">{$text}</span>";
    }

    // Helper Methods
    public static function generateBookingNumber()
    {
        $date = now()->format('Ymd');
        $lastBooking = static::whereDate('created_at', now())->orderBy('id', 'desc')->first();
        $sequence = $lastBooking ? intval(substr($lastBooking->booking_code, -3)) + 1 : 1;
        
        return 'BK' . $date . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    public function calculateTotals()
    {
        $this->total_price = $this->rental_price * $this->duration_days;
        return $this;
    }

    public function isEditable()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function isCancellable()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }
}
