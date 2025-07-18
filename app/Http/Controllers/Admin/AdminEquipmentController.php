<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminEquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = Equipment::with('category');
        
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $equipment = $query->paginate(10);
        $categories = Category::all();
        
        return view('admin.equipment.index', compact('equipment', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.equipment.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'manufacture_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'category_id' => 'required|exists:categories,id',
            'specifications' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->only([
            'name', 'description', 'price_per_day', 'stock', 'brand', 
            'model', 'manufacture_year', 'category_id', 'specifications'
        ]);
        
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        
        // Convert specifications string to array
        if (!empty($data['specifications'])) {
            $specs = [];
            $lines = explode("\n", $data['specifications']);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line && strpos($line, ':') !== false) {
                    $parts = explode(':', $line, 2);
                    if (count($parts) === 2) {
                        $specs[trim($parts[0])] = trim($parts[1]);
                    }
                }
            }
            $data['specifications'] = $specs;
        }
        
        // Handle image uploads
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/equipment'), $imageName);
                $images[] = 'images/equipment/' . $imageName;
            }
            $data['images'] = $images; // Let the model cast handle JSON encoding
        }
        
        Equipment::create($data);
        
        return redirect()->route('admin.equipment.index')
            ->with('success', 'Alat berhasil ditambahkan.');
    }

    public function show(Equipment $equipment)
    {
        $equipment->load('category');
        return view('admin.equipment.show', compact('equipment'));
    }

    public function edit(Equipment $equipment)
    {
        $categories = Category::active()->get();
        return view('admin.equipment.edit', compact('equipment', 'categories'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'manufacture_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'category_id' => 'required|exists:categories,id',
            'specifications' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->only([
            'name', 'description', 'price_per_day', 'stock', 'brand', 
            'model', 'manufacture_year', 'category_id', 'specifications'
        ]);
        
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        
        // Convert specifications string to array
        if (!empty($data['specifications'])) {
            $specs = [];
            $lines = explode("\n", $data['specifications']);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line && strpos($line, ':') !== false) {
                    $parts = explode(':', $line, 2);
                    if (count($parts) === 2) {
                        $specs[trim($parts[0])] = trim($parts[1]);
                    }
                }
            }
            $data['specifications'] = $specs;
        }
        
        // Handle image uploads
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/equipment'), $imageName);
                $images[] = 'images/equipment/' . $imageName;
            }
            $data['images'] = $images; // Let the model cast handle JSON encoding
        }
        
        $equipment->update($data);
        
        return redirect()->route('admin.equipment.index')
            ->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        
        return redirect()->route('admin.equipment.index')
            ->with('success', 'Alat berhasil dihapus.');
    }
}
