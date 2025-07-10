<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Test admin user
$admin = App\Models\User::where('email', 'admin@admin.com')->first();
if ($admin) {
    echo "Admin found: {$admin->name} - Role: {$admin->role}\n";
    echo "Is Admin: " . ($admin->isAdmin() ? 'Yes' : 'No') . "\n";
} else {
    echo "Admin not found\n";
}

// Test data
echo "Equipment count: " . App\Models\Equipment::count() . "\n";
echo "Booking count: " . App\Models\Booking::count() . "\n";
echo "User count: " . App\Models\User::count() . "\n";
