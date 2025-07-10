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
        $categories = Category::active()->get();
        $query = Equipment::active()->with('category');
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Filter by search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
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
        
        // Sort by price or name
        $sortBy = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        
        if (in_array($sortBy, ['name', 'price_per_day', 'created_at'])) {
            $query->orderBy($sortBy, $sortDirection);
        }
        
        $equipment = $query->paginate(12)->withQueryString();
        
        return view('equipment.index', compact('equipment', 'categories'));
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
