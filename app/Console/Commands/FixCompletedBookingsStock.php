<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Equipment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixCompletedBookingsStock extends Command
{
    protected $signature = 'booking:fix-completed';
    protected $description = 'Fix stock for all completed bookings';

    public function handle()
    {
        try {
            DB::beginTransaction();

            // Ambil semua booking yang completed
            $completedBookings = Booking::where('status', 'completed')->get();

            foreach ($completedBookings as $booking) {
                $equipment = Equipment::find($booking->equipment_id);
                if ($equipment) {
                    $equipment->increaseStock($booking->quantity);
                    $this->info("Returned stock for booking {$booking->booking_code} ({$booking->quantity} units of {$equipment->name})");
                }
            }

            DB::commit();
            $this->info('Stock adjustment completed successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            $this->error('Error: ' . $e->getMessage());
        }
    }
}