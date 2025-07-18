<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->boot();

try {
    // Test database connection
    $setting = new \App\Models\Setting();
    $setting->group = 'test';
    $setting->key = 'test_key';
    $setting->value = 'test_value';
    $setting->type = 'text';
    
    if ($setting->save()) {
        echo "SUCCESS: Setting created successfully\n";
        echo "ID: " . $setting->id . "\n";
    } else {
        echo "FAILED: Could not create setting\n";
    }
    
    // Count total settings
    $count = \App\Models\Setting::count();
    echo "Total settings in database: " . $count . "\n";
    
    // Count statistics settings
    $statsCount = \App\Models\Setting::where('group', 'statistics')->count();
    echo "Statistics settings in database: " . $statsCount . "\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
