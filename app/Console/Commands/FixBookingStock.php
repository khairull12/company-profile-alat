<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Equipment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixBookingStock extends Command
{
    protected $signature = 'booking:fix-stock';
    protected $description = 'Fix stock for confirmed bookings that haven\'t reduced stock';

    public function handle()
    {
        $this->info('Starting to fix booking stocks...');

        try {
            DB::beginTransaction();

            // Get all confirmed bookings
            $confirmedBookings = Booking::where('status', 'confirmed')->get();

            foreach ($confirmedBookings as $booking) {
                $equipment = Equipment::find($booking->equipment_id);
                
                if ($equipment && $equipment->hasStock($booking->quantity)) {
                    $equipment->decreaseStock($booking->quantity);
                    $this->info("Updated stock for booking {$booking->booking_code}");
                } else {
                    $this->error("Insufficient stock for booking {$booking->booking_code}");
                }
            }

            DB::commit();
            $this->info('Stock fix completed successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            $this->error('Error fixing stocks: ' . $e->getMessage());
        }
    }
}