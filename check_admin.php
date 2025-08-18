<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Checking Admin Users ===\n";

$admins = App\Models\User::where('role', 'admin')->get();

if ($admins->count() > 0) {
    echo "Found " . $admins->count() . " admin user(s):\n";
    foreach ($admins as $admin) {
        echo "- {$admin->name} ({$admin->email})\n";
    }
} else {
    echo "No admin users found. Creating default admin...\n";
    
    App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@admin.com',
        'password' => bcrypt('password'),
        'role' => 'admin'
    ]);
    
    echo "Default admin created: admin@admin.com / password\n";
}

echo "\nDone!\n";
