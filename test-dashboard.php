<?php

// Test file untuk memeriksa dashboard admin requirements
require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

$app = \Illuminate\Foundation\Application::getInstance();
$app->boot();

echo "=== Testing Dashboard Requirements ===\n\n";

try {
    // Test equipment count
    $equipmentCount = \App\Models\Equipment::count();
    echo "✅ Equipment count: $equipmentCount\n";
} catch (Exception $e) {
    echo "❌ Equipment error: " . $e->getMessage() . "\n";
}

try {
    // Test booking count
    $bookingCount = \App\Models\Booking::count();
    echo "✅ Booking count: $bookingCount\n";
} catch (Exception $e) {
    echo "❌ Booking error: " . $e->getMessage() . "\n";
}

try {
    // Test pending bookings
    $pendingCount = \App\Models\Booking::where('status', 'pending')->count();
    echo "✅ Pending bookings: $pendingCount\n";
} catch (Exception $e) {
    echo "❌ Pending bookings error: " . $e->getMessage() . "\n";
}

try {
    // Test users count
    $userCount = \App\Models\User::where('role', 'user')->count();
    echo "✅ User count: $userCount\n";
} catch (Exception $e) {
    echo "❌ User count error: " . $e->getMessage() . "\n";
}

try {
    // Test revenue
    $revenue = \App\Models\Booking::where('status', 'completed')->sum('total_price');
    echo "✅ Total revenue: Rp " . number_format($revenue, 0, ',', '.') . "\n";
} catch (Exception $e) {
    echo "❌ Revenue error: " . $e->getMessage() . "\n";
}

try {
    // Test admin user
    $admin = \App\Models\User::where('email', 'admin@admin.com')->first();
    if ($admin) {
        echo "✅ Admin user found: {$admin->name} ({$admin->role})\n";
    } else {
        echo "❌ Admin user not found\n";
    }
} catch (Exception $e) {
    echo "❌ Admin user error: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
