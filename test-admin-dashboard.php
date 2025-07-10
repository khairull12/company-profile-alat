<?php

// Test if the admin dashboard is working properly
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a test request
$request = Illuminate\Http\Request::create('/admin/dashboard', 'GET');

// Mock authentication
$admin = App\Models\User::where('email', 'admin@admin.com')->first();
if ($admin) {
    echo "Found admin user: {$admin->name}\n";
    
    // Test admin controller dashboard method directly
    $controller = new App\Http\Controllers\Admin\AdminController();
    
    // Mock authentication
    Illuminate\Support\Facades\Auth::login($admin);
    
    try {
        $response = $controller->dashboard();
        echo "Dashboard method executed successfully\n";
        
        // Check if response is a view
        if ($response instanceof Illuminate\View\View) {
            echo "Response is a view\n";
            
            // Get the view data
            $data = $response->getData();
            echo "View data:\n";
            foreach ($data as $key => $value) {
                echo "  {$key}: {$value}\n";
            }
        } else {
            echo "Response type: " . get_class($response) . "\n";
        }
    } catch (\Exception $e) {
        echo "Error executing dashboard method: " . $e->getMessage() . "\n";
        echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    }
} else {
    echo "Admin user not found\n";
}
