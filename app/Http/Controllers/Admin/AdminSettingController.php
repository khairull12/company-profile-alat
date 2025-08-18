<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSettingController extends Controller
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

    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function create()
    {
        return view('admin.settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'group' => 'required|string|max:255',
            'key' => 'required|string|max:255|unique:settings,key',
            'value' => 'nullable|string',
            'type' => 'required|in:text,textarea,image,select,number,email,url'
        ]);

        Setting::create([
            'group' => $request->group,
            'key' => $request->key,
            'value' => $request->value,
            'type' => $request->type
        ]);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil ditambahkan.');
    }

    public function edit($group)
    {
        $settings = Setting::where('group', $group)->get();
        return view('admin.settings.edit', compact('settings', 'group'));
    }

    public function update(Request $request, $group)
    {
        try {
            \Log::info('Settings update request', [
                'group' => $group,
                'settings' => $request->settings,
                'files' => $request->allFiles()
            ]);

            $request->validate([
                'settings' => 'required|array',
                'settings.*' => 'nullable'
            ]);

            $updatedCount = 0;

            foreach ($request->settings as $key => $value) {
                $setting = Setting::where('key', $key)->first();
                
                if (!$setting) {
                    \Log::warning("Setting not found: $key");
                    continue;
                }

                // Handle image uploads
                if ($setting->type == 'image' && $request->hasFile("settings.$key")) {
                    $image = $request->file("settings.$key");
                    
                    // Validate image
                    $request->validate([
                        "settings.$key" => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                    ]);
                    
                    // Create directory if not exists
                    $uploadPath = public_path('storage/settings');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
                    
                    // Delete old image if exists
                    if ($setting->value && file_exists(public_path('storage/' . $setting->value))) {
                        unlink(public_path('storage/' . $setting->value));
                    }
                    
                    // Upload new image
                    $imageName = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                    $image->move($uploadPath, $imageName);
                    $value = 'settings/' . $imageName;
                    
                    \Log::info("Image uploaded for $key: $value");
                } else if ($setting->type == 'image' && !$request->hasFile("settings.$key")) {
                    // If no new image uploaded, keep the existing value
                    \Log::info("No new image for $key, keeping existing");
                    continue;
                }

                // Only update if value has changed
                if ($setting->value !== $value) {
                    Setting::where('key', $key)->update(['value' => $value]);
                    $updatedCount++;
                    \Log::info("Setting updated: $key = $value");
                }
            }

            $message = $updatedCount > 0 
                ? "Pengaturan berhasil diperbarui. {$updatedCount} pengaturan diubah."
                : "Tidak ada perubahan yang disimpan.";

            return redirect()->route('admin.settings.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Settings update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan pengaturan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);
        $setting->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil dihapus.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'key' => 'required|string'
        ]);

        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images/settings'), $imageName);
        
        Setting::where('key', $request->key)->update(['value' => 'images/settings/' . $imageName]);

        return response()->json([
            'success' => true,
            'path' => 'images/settings/' . $imageName
        ]);
    }

    public function statistics()
    {
        $statistics = Setting::where('group', 'statistics')->orderBy('key')->get();
        return view('admin.settings.statistics', compact('statistics'));
    }

    public function updateStatistics(Request $request)
    {
        $request->validate([
            'total_equipment' => 'required|string|max:50',
            'completed_projects' => 'required|string|max:50',
            'client_satisfaction' => 'required|string|max:50',
            'years_experience' => 'required|string|max:50',
        ]);

        $statisticsData = [
            'total_equipment' => $request->total_equipment,
            'completed_projects' => $request->completed_projects,
            'client_satisfaction' => $request->client_satisfaction,
            'years_experience' => $request->years_experience,
        ];

        foreach ($statisticsData as $key => $value) {
            Setting::where('group', 'statistics')
                   ->where('key', $key)
                   ->update(['value' => $value]);
        }

        return redirect()->route('admin.settings.statistics')
                        ->with('success', 'Statistik berhasil diperbarui!');
    }
}
