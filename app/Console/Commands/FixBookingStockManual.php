<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Equipment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixBookingStockManual extends Command
{
    protected $signature = 'booking:fix-stock-manual {code}';
    protected $description = 'Fix stock for a specific booking';

    public function handle()
    {
        $code = $this->argument('code');
        
        try {
            DB::beginTransaction();
            
            $booking = Booking::where('booking_code', $code)->first();
            if (!$booking) {
                $this->error("Booking not found: {$code}");
                return 1;
            }

            $equipment = Equipment::find($booking->equipment_id);
            if (!$equipment) {
                $this->error("Equipment not found for booking: {$code}");
                return 1;
            }

            if ($booking->status === 'confirmed') {
                if ($equipment->hasStock($booking->quantity)) {
                    $equipment->decreaseStock($booking->quantity);
                    $this->info("Successfully decreased stock for {$equipment->name} by {$booking->quantity}");
                } else {
                    $this->error("Insufficient stock for {$equipment->name}. Current stock: {$equipment->stock}");
                    return 1;
                }
            }

            DB::commit();
            $this->info('Stock updated successfully');

        } catch (\Exception $e) {
            DB::rollback();
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}