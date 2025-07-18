<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Category;
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
        // Basic stats
        $totalEquipment = Equipment::count();
        $totalCategories = Category::count();
        $availableEquipment = Equipment::where('stock', '>', 0)->count();
        $totalUsers = User::users()->count();
        
        // Monthly equipment trends
        $monthlyEquipmentData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyEquipmentData[] = [
                'month' => $date->format('M Y'),
                'count' => Equipment::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count()
            ];
        }
        
        // Equipment populer (berdasarkan stok dan status aktif)
        $popularEquipment = Equipment::where('is_active', true)
            ->orderBy('stock', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Recent equipment (5 terbaru)
        $recentEquipment = Equipment::with('category')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Statistik kategori dengan total equipment
        $categories = Category::withCount('equipment')
            ->orderBy('equipment_count', 'desc')
            ->get();
            
        // Quick stats for cards
        $quickStats = [
            'total_value' => Equipment::sum('price_per_day'),
            'avg_price' => Equipment::avg('price_per_day'),
            'newest_equipment' => Equipment::latest()->first(),
            'most_stocked' => Equipment::orderBy('stock', 'desc')->first()
        ];
            
        return view('admin.dashboard', compact(
            'totalEquipment',
            'totalCategories',
            'availableEquipment',
            'totalUsers',
            'monthlyEquipmentData',
            'popularEquipment',
            'recentEquipment',
            'categories',
            'quickStats'
        ));
    }
}
