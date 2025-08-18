<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Equipment;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // Get existing users and equipment
        $users = User::where('role', 'user')->get();
        $equipment = Equipment::all();
        
        if ($users->count() === 0 || $equipment->count() === 0) {
            $this->command->warn('Need users and equipment data first. Run UserSeeder and EquipmentSeeder first.');
            return;
        }

        // Create sample bookings (skip existing ones)
        $existingCodes = Booking::pluck('booking_code')->toArray();
        $bookings = collect([
            [
                'booking_code' => 'BK20250101001',
                'user_id' => $users->random()->id,
                'equipment_id' => $equipment->random()->id,
                'start_date' => Carbon::now()->addDays(1),
                'end_date' => Carbon::now()->addDays(3),
                'duration_days' => 3,
                'status' => 'pending',
                'notes' => 'Pekerjaan konstruksi jalan',
                'admin_notes' => 'Perlu konfirmasi operator',
            ],
            [
                'booking_code' => 'BK20250101002',
                'user_id' => $users->random()->id,
                'equipment_id' => $equipment->random()->id,
                'start_date' => Carbon::now()->addDays(5),
                'end_date' => Carbon::now()->addDays(10),
                'duration_days' => 6,
                'status' => 'confirmed',
                'notes' => 'Proyek pembangunan gedung',
                'admin_notes' => 'Sudah dikonfirmasi, siap operasi',
                'confirmed_at' => Carbon::now(),
            ],
            [
                'booking_code' => 'BK20250101003',
                'user_id' => $users->random()->id,
                'equipment_id' => $equipment->random()->id,
                'start_date' => Carbon::now()->subDays(2),
                'end_date' => Carbon::now()->addDays(1),
                'duration_days' => 4,
                'status' => 'confirmed',
                'notes' => 'Pekerjaan penggalian fondasi',
                'admin_notes' => 'Sedang beroperasi di lapangan',
                'confirmed_at' => Carbon::now()->subDays(3),
            ],
            [
                'booking_code' => 'BK20250101004',
                'user_id' => $users->random()->id,
                'equipment_id' => $equipment->random()->id,
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->subDays(5),
                'duration_days' => 6,
                'status' => 'completed',
                'notes' => 'Proyek jalan raya selesai',
                'admin_notes' => 'Selesai tepat waktu, alat dalam kondisi baik',
                'confirmed_at' => Carbon::now()->subDays(12),
            ],
            [
                'booking_code' => 'BK20250101005',
                'user_id' => $users->random()->id,
                'equipment_id' => $equipment->random()->id,
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(20),
                'duration_days' => 6,
                'status' => 'cancelled',
                'notes' => 'Proyek ditunda oleh klien',
                'admin_notes' => 'Dibatalkan karena kendala cuaca',
            ],
        ])->filter(function($booking) use ($existingCodes) {
            return !in_array($booking['booking_code'], $existingCodes);
        });

        foreach ($bookings as $bookingData) {
            $equipment_item = Equipment::find($bookingData['equipment_id']);
            
            $booking = new Booking();
            $booking->booking_code = $bookingData['booking_code'];
            $booking->user_id = $bookingData['user_id'];
            $booking->equipment_id = $bookingData['equipment_id'];
            $booking->start_date = $bookingData['start_date'];
            $booking->end_date = $bookingData['end_date'];
            $booking->duration_days = $bookingData['duration_days'];
            $booking->daily_rate = $equipment_item->price_per_day;
            $booking->total_amount = $equipment_item->price_per_day * $bookingData['duration_days'];
            $booking->status = $bookingData['status'];
            $booking->notes = $bookingData['notes'];
            $booking->admin_notes = $bookingData['admin_notes'];
            
            if (isset($bookingData['confirmed_at'])) {
                $booking->confirmed_at = $bookingData['confirmed_at'];
            }
            
            $booking->save();
        }

        $this->command->info('Booking test data created successfully!');
    }
}
