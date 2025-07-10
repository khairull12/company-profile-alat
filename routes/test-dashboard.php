<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/test-dashboard', function () {
    try {
        // Auto-login admin for testing
        $admin = App\Models\User::where('email', 'admin@admin.com')->first();
        if ($admin) {
            Auth::login($admin);
        }
        
        // Check if user is authenticated and is admin
        if (!Auth::check()) {
            return 'Not authenticated';
        }
        
        if (!Auth::user()->isAdmin()) {
            return 'Not admin';
        }
        
        $totalEquipment = App\Models\Equipment::count();
        $totalBookings = App\Models\Booking::count();
        $pendingBookings = App\Models\Booking::where('status', 'pending')->count();
        $totalUsers = App\Models\User::count();
        
        $monthlyRevenue = App\Models\Booking::whereMonth('created_at', now()->month)
            ->where('status', 'completed')
            ->sum('total_amount');
        
        return response()->json([
            'user' => Auth::user()->name,
            'role' => Auth::user()->role,
            'isAdmin' => Auth::user()->isAdmin(),
            'totalEquipment' => $totalEquipment,
            'totalBookings' => $totalBookings,
            'pendingBookings' => $pendingBookings,
            'totalUsers' => $totalUsers,
            'monthlyRevenue' => $monthlyRevenue,
        ]);
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/test-settings', function () {
    try {
        // Auto-login admin for testing
        $admin = App\Models\User::where('email', 'admin@admin.com')->first();
        if ($admin) {
            Auth::login($admin);
        }
        
        // Check if user is authenticated and is admin
        if (!Auth::check()) {
            return 'Not authenticated';
        }
        
        if (!Auth::user()->isAdmin()) {
            return 'Not admin';
        }
        
        // Test settings
        $settings = App\Models\Setting::all();
        $settingsGrouped = $settings->groupBy('group');
        
        return response()->json([
            'user' => Auth::user()->name,
            'role' => Auth::user()->role,
            'isAdmin' => Auth::user()->isAdmin(),
            'settingsCount' => $settings->count(),
            'settingsGroups' => $settingsGrouped->keys(),
            'settings' => $settings->toArray(),
        ]);
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
