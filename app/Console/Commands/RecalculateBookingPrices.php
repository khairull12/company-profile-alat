<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RecalculateBookingPrices extends Command
{
    protected $signature = 'booking:recalculate-prices';
    protected $description = 'Recalculate total prices for all bookings';

    public function handle()
    {
        try {
            DB::beginTransaction();

            $bookings = Booking::all();
            $this->info('Found ' . $bookings->count() . ' bookings to update');

            foreach ($bookings as $booking) {
                $oldPrice = $booking->total_price;
                $booking->calculateTotalPrice();
                $newPrice = $booking->total_price;

                $this->info("Booking {$booking->booking_code}: {$oldPrice} -> {$newPrice}");
            }

            DB::commit();
            $this->info('Successfully updated all booking prices');

        } catch (\Exception $e) {
            DB::rollback();
            $this->error('Error updating prices: ' . $e->getMessage());
        }
    }
}