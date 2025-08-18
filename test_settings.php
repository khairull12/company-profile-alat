<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test data
echo "Testing Settings Update...\n";

// Check current company settings
echo "\n=== Current Company Settings ===\n";
$companySettings = App\Models\Setting::where('group', 'company')->get();
foreach ($companySettings as $setting) {
    echo "{$setting->key}: {$setting->value} ({$setting->type})\n";
}

// Test update
echo "\n=== Testing Update ===\n";
$testUpdate = App\Models\Setting::where('key', 'company_name')->first();
if ($testUpdate) {
    $oldValue = $testUpdate->value;
    $testUpdate->update(['value' => 'Test Company Update']);
    echo "Updated company_name from '{$oldValue}' to '{$testUpdate->fresh()->value}'\n";
    
    // Restore
    $testUpdate->update(['value' => $oldValue]);
    echo "Restored company_name to '{$oldValue}'\n";
} else {
    echo "company_name setting not found!\n";
}

echo "\nTest completed!\n";
