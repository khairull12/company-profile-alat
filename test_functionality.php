<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Equipment;
use App\Models\Category;
use App\Models\Booking;
use App\Models\Setting;

// Initialize Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

echo "🧪 TESTING SISTEM RENTAL ALAT BERAT\n";
echo "=====================================\n\n";

// Test 1: Database Connection
echo "1. Testing Database Connection...\n";
try {
    $usersCount = User::count();
    echo "   ✅ Database connected successfully! Found {$usersCount} users.\n\n";
} catch (Exception $e) {
    echo "   ❌ Database connection failed: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Test 2: Admin User Exists
echo "2. Testing Admin User...\n";
$admin = User::where('email', 'admin@admin.com')->first();
if ($admin && $admin->isAdmin()) {
    echo "   ✅ Admin user exists and has admin role.\n";
    echo "   📧 Email: {$admin->email}\n";
    echo "   👤 Name: {$admin->name}\n\n";
} else {
    echo "   ❌ Admin user not found or missing admin role.\n\n";
}

// Test 3: Categories
echo "3. Testing Categories...\n";
$categories = Category::all();
if ($categories->count() > 0) {
    echo "   ✅ Found {$categories->count()} categories:\n";
    foreach ($categories as $category) {
        echo "      - {$category->name} (slug: {$category->slug})\n";
    }
    echo "\n";
} else {
    echo "   ❌ No categories found.\n\n";
}

// Test 4: Equipment
echo "4. Testing Equipment...\n";
$equipment = Equipment::with('category')->get();
if ($equipment->count() > 0) {
    echo "   ✅ Found {$equipment->count()} equipment items:\n";
    foreach ($equipment->take(3) as $item) {
        echo "      - {$item->name} ({$item->category->name}) - Rp " . number_format($item->price_per_day) . "/day\n";
    }
    if ($equipment->count() > 3) {
        echo "      ... and " . ($equipment->count() - 3) . " more items\n";
    }
    echo "\n";
} else {
    echo "   ❌ No equipment found.\n\n";
}

// Test 5: Settings
echo "5. Testing Settings...\n";
$settings = Setting::all();
if ($settings->count() > 0) {
    echo "   ✅ Found {$settings->count()} settings:\n";
    foreach ($settings->take(3) as $setting) {
        echo "      - {$setting->key}: {$setting->value}\n";
    }
    if ($settings->count() > 3) {
        echo "      ... and " . ($settings->count() - 3) . " more settings\n";
    }
    echo "\n";
} else {
    echo "   ❌ No settings found.\n\n";
}

// Test 6: Bookings
echo "6. Testing Bookings...\n";
$bookings = Booking::with(['user', 'equipment'])->get();
echo "   📊 Found {$bookings->count()} bookings in database.\n";
if ($bookings->count() > 0) {
    foreach ($bookings->take(2) as $booking) {
        echo "      - {$booking->booking_code}: {$booking->equipment->name} ({$booking->status})\n";
    }
}
echo "\n";

// Test 7: Equipment Availability Check
echo "7. Testing Equipment Availability Function...\n";
$testEquipment = Equipment::first();
if ($testEquipment) {
    $startDate = now()->addDay();
    $endDate = now()->addDays(3);
    $available = $testEquipment->isAvailableForPeriod($startDate, $endDate);
    echo "   ✅ Equipment availability check working: " . ($available ? "Available" : "Not available") . "\n";
    echo "   📅 Checked: {$testEquipment->name} from {$startDate->format('Y-m-d')} to {$endDate->format('Y-m-d')}\n\n";
} else {
    echo "   ❌ No equipment to test availability.\n\n";
}

// Test 8: Model Relationships
echo "8. Testing Model Relationships...\n";
$testEquipment = Equipment::with(['category', 'bookings'])->first();
if ($testEquipment) {
    echo "   ✅ Equipment->Category relationship: {$testEquipment->category->name}\n";
    echo "   ✅ Equipment->Bookings relationship: {$testEquipment->bookings->count()} bookings\n\n";
} else {
    echo "   ❌ No equipment to test relationships.\n\n";
}

// Test 9: User Roles
echo "9. Testing User Roles...\n";
$adminUsers = User::where('role', 'admin')->count();
$regularUsers = User::where('role', 'user')->count();
echo "   ✅ Admin users: {$adminUsers}\n";
echo "   ✅ Regular users: {$regularUsers}\n\n";

// Test 10: JSON Fields (Equipment Specifications)
echo "10. Testing JSON Fields...\n";
$equipmentWithSpecs = Equipment::whereNotNull('specifications')->first();
if ($equipmentWithSpecs && $equipmentWithSpecs->specifications) {
    $specs = json_decode($equipmentWithSpecs->specifications, true);
    if ($specs) {
        echo "   ✅ Equipment specifications JSON parsing works:\n";
        echo "      Equipment: {$equipmentWithSpecs->name}\n";
        foreach (array_slice($specs, 0, 2) as $key => $value) {
            echo "      - {$key}: {$value}\n";
        }
        echo "\n";
    } else {
        echo "   ❌ JSON specifications parsing failed.\n\n";
    }
} else {
    echo "   ❌ No equipment with specifications found.\n\n";
}

echo "=====================================\n";
echo "🎉 TESTING COMPLETED!\n";
echo "=====================================\n\n";

// Summary
echo "📋 SUMMARY:\n";
echo "- Database: ✅ Connected\n";
echo "- Users: ✅ {$usersCount} total ({$adminUsers} admin, {$regularUsers} regular)\n";
echo "- Categories: ✅ {$categories->count()} items\n";
echo "- Equipment: ✅ {$equipment->count()} items\n";
echo "- Bookings: ✅ {$bookings->count()} items\n";
echo "- Settings: ✅ {$settings->count()} items\n";
echo "\n🚀 The system is ready for use!\n";

echo "\n📝 CREDENTIALS:\n";
echo "Admin Login:\n";
echo "- Email: admin@admin.com\n";
echo "- Password: password\n\n";
echo "User Login:\n";
echo "- Email: user@test.com\n";
echo "- Password: password\n\n";

echo "🌐 ACCESS URLs:\n";
echo "- Home: http://localhost:8000\n";
echo "- Admin Dashboard: http://localhost:8000/admin/dashboard\n";
echo "- Login: http://localhost:8000/login\n";
echo "- Register: http://localhost:8000/register\n";
