<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        // Get all active categories
        $categories = Category::orderBy('name')->get();
        
        // Initialize equipment query with category relationship
        $query = Equipment::with('category');
        
        // Filter by category if specified
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Filter by search term
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        // Filter by price range
        if ($request->filled('price_range')) {
            $priceRange = $request->price_range;
            if ($priceRange === '0-500000') {
                $query->where('price_per_day', '<=', 500000);
            } elseif ($priceRange === '500000-1000000') {
                $query->whereBetween('price_per_day', [500000, 1000000]);
            } elseif ($priceRange === '1000000-2000000') {
                $query->whereBetween('price_per_day', [1000000, 2000000]);
            } elseif ($priceRange === '2000000+') {
                $query->where('price_per_day', '>', 2000000);
            }
        }
        
        // Default sorting by name ascending
        $sortBy = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        
        if (in_array($sortBy, ['name', 'price_per_day', 'created_at'])) {
            $query->orderBy($sortBy, $sortDirection);
        }
        
        // Get paginated results with larger per-page count
        $equipment = $query->paginate(16)->withQueryString();
        
        // Calculate statistics for the view
        $stats = [
            'total' => Equipment::count(),
            'available' => Equipment::where('stock', '>', 0)->count(),
            'categories' => $categories->count(),
            'avgPrice' => Equipment::where('stock', '>', 0)->avg('price_per_day') ?? 0
        ];
        
        return view('equipment.index', compact('equipment', 'categories', 'stats'));
    }

    public function show(Equipment $equipment)
    {
        if (!$equipment->is_active) {
            abort(404);
        }
        
        $relatedEquipment = Equipment::active()
            ->where('category_id', $equipment->category_id)
            ->where('id', '!=', $equipment->id)
            ->take(4)
            ->get();
            
        return view('equipment.show', compact('equipment', 'relatedEquipment'));
    }
}
