<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminEquipmentController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminReportController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/vision-mission', [HomeController::class, 'visionMission'])->name('vision-mission');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Equipment routes
Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment.index');
Route::get('/equipment/{equipment}', [EquipmentController::class, 'show'])->name('equipment.show');

// Booking routes (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{equipment}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/check-availability', [BookingController::class, 'checkAvailability'])->name('bookings.check-availability');
});

// User dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Equipment management
    Route::resource('equipment', AdminEquipmentController::class);
    
    // Booking management
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
    Route::patch('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::patch('/bookings/{booking}/complete', [AdminBookingController::class, 'complete'])->name('bookings.complete');
    Route::get('/bookings/report', [AdminBookingController::class, 'report'])->name('bookings.report');
    
    // Settings management
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/create', [AdminSettingController::class, 'create'])->name('settings.create');
    Route::post('/settings', [AdminSettingController::class, 'store'])->name('settings.store');
    Route::get('/settings/{group}/edit', [AdminSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/{group}', [AdminSettingController::class, 'update'])->name('settings.update');
    Route::delete('/settings/{id}', [AdminSettingController::class, 'destroy'])->name('settings.destroy');
    Route::post('/settings/upload-image', [AdminSettingController::class, 'uploadImage'])->name('settings.upload-image');
    
    // Reports
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [AdminReportController::class, 'export'])->name('reports.export');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Simple test route
Route::get('/test', function () {
    return 'Server is working! Current time: ' . now();
});

// Auto login admin untuk testing (remove in production)
Route::get('/auto-login-admin', function () {
    $admin = App\Models\User::where('email', 'admin@admin.com')->first();
    if ($admin) {
        Auth::login($admin);
        return redirect()->route('admin.dashboard');
    }
    return 'Admin user not found';
});

// Test admin route
Route::get('/test-admin', function () {
    if (!Auth::check()) {
        return 'Not logged in';
    }
    
    $user = Auth::user();
    return "Logged in as: {$user->name} - Role: {$user->role} - Is Admin: " . ($user->isAdmin() ? 'Yes' : 'No');
})->middleware('auth');

// Debug route (remove in production)
Route::get('/debug-admin', function () {
    $admin = App\Models\User::where('email', 'admin@admin.com')->first();
    $equipmentCount = App\Models\Equipment::count();
    $bookingCount = App\Models\Booking::count();
    $settingsCount = App\Models\Setting::count();
    
    return response()->json([
        'admin_user' => $admin ? ['name' => $admin->name, 'role' => $admin->role] : 'Not found',
        'equipment_count' => $equipmentCount,
        'booking_count' => $bookingCount,
        'settings_count' => $settingsCount,
    ]);
});

// Test route untuk booking form (development only)
Route::get('/test-booking/{equipment}', function (App\Models\Equipment $equipment) {
    return view('bookings.create', compact('equipment'));
})->name('test.booking');

// Home route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Temporary placeholder routes untuk testing
Route::get('/home', function() {
    return redirect()->route('home');
});

require __DIR__.'/auth.php';

// Include test dashboard route
include __DIR__.'/test-dashboard.php';
