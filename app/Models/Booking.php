<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'user_id',
        'equipment_id',
        'start_date',
        'end_date',
        'duration_days',
        'daily_rate',
        'total_amount',
        'status',
        'notes',
        'admin_notes',
        'confirmed_at',
        'confirmed_by'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'daily_rate' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'confirmed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function generateBookingCode()
    {
        $date = Carbon::now()->format('Ymd');
        $lastBooking = self::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastBooking ? (int)substr($lastBooking->booking_code, -3) + 1 : 1;
        
        return 'BK' . $date . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (!$booking->booking_code) {
                $booking->booking_code = $booking->generateBookingCode();
            }
        });
    }
}
