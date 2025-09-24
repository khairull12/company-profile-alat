<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminEquipmentController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminBookingController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/vision-mission', [HomeController::class, 'visionMission'])->name('vision-mission');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Equipment routes
Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment.index');
Route::get('/equipment/{equipment}', [EquipmentController::class, 'show'])->name('equipment.show');

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
    Route::resource('bookings', AdminBookingController::class);
    Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.update-status');
    // Report routes have been removed
    
    // Settings management
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/create', [AdminSettingController::class, 'create'])->name('settings.create');
    Route::post('/settings', [AdminSettingController::class, 'store'])->name('settings.store');
    Route::post('/settings/upload-image', [AdminSettingController::class, 'uploadImage'])->name('settings.upload-image');
    
    // Statistics management (must come before general {group} routes)
    Route::get('/settings/statistics', [AdminSettingController::class, 'statistics'])->name('settings.statistics');
    Route::put('/settings/statistics', [AdminSettingController::class, 'updateStatistics'])->name('settings.statistics.update');
    
    // General settings routes (must come after specific routes)
    Route::get('/settings/{group}/edit', [AdminSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/{group}', [AdminSettingController::class, 'update'])->name('settings.update');
    Route::delete('/settings/{id}', [AdminSettingController::class, 'destroy'])->name('settings.destroy');
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
    $settingsCount = App\Models\Setting::count();
    
    return response()->json([
        'admin_user' => $admin ? ['name' => $admin->name, 'role' => $admin->role] : 'Not found',
        'equipment_count' => $equipmentCount,
        'settings_count' => $settingsCount,
    ]);
});

// Home route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Temporary placeholder routes untuk testing
Route::get('/home', function() {
    return redirect()->route('home');
});

require __DIR__.'/auth.php';
