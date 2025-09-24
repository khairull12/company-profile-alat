<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class CheckBooking extends Command
{
    protected $signature = 'booking:check {code}';
    protected $description = 'Check booking details by code';

    public function handle()
    {
        $code = $this->argument('code');
        $booking = Booking::where('booking_code', $code)->first();
        
        if (!$booking) {
            $this->error("Booking not found: {$code}");
            return 1;
        }

        $this->info('Booking Details:');
        $this->table(
            ['Field', 'Value'],
            [
                ['Booking Code', $booking->booking_code],
                ['Equipment', $booking->equipment->name ?? 'N/A'],
                ['Quantity', $booking->quantity ?? 'Not set'],
                ['Status', $booking->status],
                ['Customer', $booking->customer_name],
                ['Start Date', $booking->start_date],
                ['End Date', $booking->end_date],
            ]
        );
    }
}