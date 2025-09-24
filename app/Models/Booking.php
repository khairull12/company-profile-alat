<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use App\Models\User;

class Booking extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            // Generate booking code if not set
            if (!$booking->booking_code) {
                $booking->booking_code = static::generateBookingNumber();
            }
            
            // Calculate total price if not set
            if (!$booking->total_price) {
                $booking->calculateTotalPrice();
            }
        });

        static::updating(function ($booking) {
            // Recalculate price if relevant fields change
            if ($booking->isDirty(['start_date', 'end_date', 'rental_price', 'quantity'])) {
                $booking->calculateTotalPrice();
            }
        });
    }
    
    protected $fillable = [
        'booking_code',
        'equipment_id',
        'quantity',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
            'active' => 'bg-success', // alias support
            'completed' => 'bg-primary',
            'cancelled' => 'bg-danger'
        ];

        $statusTexts = [
            'pending' => 'Pending',
            'confirmed' => 'Dikonfirmasi',
            'ongoing' => 'Berlangsung',
            'active' => 'Berlangsung', // alias support
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];

        $class = $statusClasses[$this->status] ?? 'bg-secondary';
        $text = $statusTexts[$this->status] ?? ucfirst($this->status);

        return "<span class=\"badge {$class}\">{$text}</span>";
    }

    public function getPaymentStatusBadge()
    {
        $status = $this->payment_status ?? 'unpaid';

        $classes = [
            'unpaid' => 'bg-secondary',
            'pending' => 'bg-secondary', // alias
            'partial' => 'bg-warning text-dark',
            'paid' => 'bg-success',
            'overdue' => 'bg-danger',
            'refunded' => 'bg-info',
        ];

        $texts = [
            'unpaid' => 'Belum Bayar',
            'pending' => 'Belum Bayar',
            'partial' => 'Dibayar Sebagian',
            'paid' => 'Lunas',
            'overdue' => 'Terlambat',
            'refunded' => 'Dikembalikan',
        ];

        $class = $classes[$status] ?? 'bg-secondary';
        $text = $texts[$status] ?? ucfirst($status);
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

    public function calculateTotalPrice()
    {
        // Pastikan tanggal valid
        if ($this->start_date && $this->end_date) {
            // Hitung durasi dalam hari
            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);
            $duration = $start->diffInDays($end) + 1; // +1 karena termasuk hari pertama

            // Ambil harga sewa per hari dari equipment
            if ($this->equipment) {
                $rental_price = $this->equipment->price_per_day ?? 0;
                $quantity = $this->quantity ?? 1;
                
                // Hitung total
                $this->duration_days = $duration;
                $this->rental_price = $rental_price;
                $this->total_price = $rental_price * $duration * $quantity;
            }
        }
        
        return $this;
    }

    // Accessors/Helpers used in views
    public function getDurationDays()
    {
        if ($this->duration_days) {
            return (int) $this->duration_days;
        }
        if ($this->start_date && $this->end_date) {
            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);
            return $start->diffInDays($end) + 1;
        }
        return 0;
    }

    public function getTotalAmountAttribute()
    {
        $rental = (float) ($this->rental_cost ?? 0);
        $delivery = (float) ($this->delivery_cost ?? 0);
        $operator = (float) ($this->operator_cost ?? 0);
        $insurance = (float) ($this->insurance_cost ?? 0);
        $additional = (float) ($this->additional_cost ?? 0);
        return $rental + $delivery + $operator + $insurance + $additional;
    }

    public function getPaidAmountAttribute($value)
    {
        return (float) ($value ?? 0);
    }

    public function getDepositAmountAttribute($value)
    {
        return (float) ($value ?? 0);
    }

    public function getDeliveryCostAttribute($value)
    {
        return (float) ($value ?? 0);
    }

    public function getOperatorCostAttribute($value)
    {
        return (float) ($value ?? 0);
    }

    public function getInsuranceCostAttribute($value)
    {
        return (float) ($value ?? 0);
    }

    public function getAdditionalCostAttribute($value)
    {
        return (float) ($value ?? 0);
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
