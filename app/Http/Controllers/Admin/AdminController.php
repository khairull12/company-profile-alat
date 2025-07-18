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
        
        // Equipment populer (berdasarkan stok)
        $popularEquipment = Equipment::where('is_active', true)
            ->orderBy('stock', 'desc')
            ->take(5)
            ->get();
        
        // Statistik kategori
        $categories = Category::withCount('equipment')
            ->orderBy('equipment_count', 'desc')
            ->get();
            
        return view('admin.dashboard', compact(
            'totalEquipment',
            'totalCategories',
            'availableEquipment',
            'totalUsers',
            'popularEquipment',
            'categories'
        ));
    }
}
