<?php

use App\Models\User;
use App\Models\Equipment;
use App\Models\Booking;

// Check admin user
$admin = User::where('email', 'admin@example.com')->first();
if ($admin) {
    echo "✅ Admin user found: {$admin->name} - Role: {$admin->role}\n";
} else {
    echo "❌ Admin user not found\n";
}

// Check equipment count
$equipmentCount = Equipment::count();
echo "📋 Total Equipment: {$equipmentCount}\n";

// Check booking count
$bookingCount = Booking::count();
echo "📅 Total Bookings: {$bookingCount}\n";

// Check settings
$settings = \App\Models\Setting::count();
echo "⚙️ Total Settings: {$settings}\n";
