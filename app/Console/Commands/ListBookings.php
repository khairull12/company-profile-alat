<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ListBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all bookings with their details';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bookings = \App\Models\Booking::with('equipment')->get();
        
        $this->info('Current Bookings:');
        $this->table(
            ['ID', 'Code', 'Equipment', 'Status', 'Quantity', 'Total Price'],
            $bookings->map(function ($booking) {
                return [
                    $booking->id,
                    $booking->booking_code,
                    $booking->equipment->name ?? 'N/A',
                    $booking->status,
                    $booking->quantity,
                    number_format($booking->total_price, 0, ',', '.')
                ];
            })
        );
        
        // Show statistics
        $this->info("\nStatistics:");
        $this->line("Total Bookings: " . $bookings->count());
        $this->line("Pending: " . $bookings->where('status', 'pending')->count());
        $this->line("Confirmed: " . $bookings->where('status', 'confirmed')->count());
        $this->line("Completed: " . $bookings->where('status', 'completed')->count());
        $this->line("Monthly Revenue: Rp " . number_format(
            $bookings->where('status', 'completed')
                ->filter(function($booking) {
                    return $booking->created_at->isCurrentMonth();
                })
                ->sum('total_price'),
            0, ',', '.'
        ));
    }
}
