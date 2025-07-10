<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user || !$user->isAdmin()) {
                abort(403, 'Access denied. Admin role required.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $totalEquipment = Equipment::count();
        $totalBookings = Booking::count();
        $pendingBookings = Booking::pending()->count();
        $totalUsers = User::users()->count();
        $totalRevenue = Booking::where('status', 'completed')->sum('total_amount');
        
        // Statistik bulanan
        $monthlyBookings = Booking::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $monthlyRevenue = Booking::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
        
        // Booking hari ini
        $todayBookings = Booking::whereDate('created_at', today())->count();
        
        // Equipment paling populer
        $popularEquipment = Equipment::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();
        
        $recentBookings = Booking::with(['user', 'equipment'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return view('admin.dashboard', compact(
            'totalEquipment',
            'totalBookings', 
            'pendingBookings',
            'totalUsers',
            'totalRevenue',
            'monthlyBookings',
            'monthlyRevenue',
            'todayBookings',
            'popularEquipment',
            'recentBookings'
        ));
    }
}
