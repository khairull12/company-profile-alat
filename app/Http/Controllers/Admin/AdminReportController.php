<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminReportController extends Controller
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
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        $equipmentId = $request->input('equipment_id');
        $userId = $request->input('user_id');
        
        // Equipment analytics
        $equipment = Equipment::with('category')->get();
        $totalEquipment = $equipment->count();
        $availableEquipment = $equipment->where('stock', '>', 0)->count();
        $activeEquipment = $equipment->where('is_active', true)->count();
        
        // Category analytics
        $categories = Category::withCount('equipment')->get();
        
        // Equipment usage (berdasarkan views dan interaksi)
        $equipmentUsage = Equipment::with('category')
            ->where('is_active', true)
            ->orderBy('stock', 'desc')
            ->take(10)
            ->get()
            ->map(function($item) {
                return [
                    'equipment' => $item,
                    'total_views' => rand(10, 100), // Simulasi data views
                    'total_inquiries' => rand(5, 50), // Simulasi data inquiries
                    'availability_rate' => round(($item->stock / ($item->stock + rand(1, 10))) * 100, 2)
                ];
            });
        
        // User activity
        $userActivity = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function($user) {
                return [
                    'user' => $user,
                    'total_visits' => rand(5, 30), // Simulasi data visits
                    'last_activity' => $user->updated_at,
                    'engagement_score' => rand(60, 100) // Simulasi engagement score
                ];
            });
        
        // Monthly stats
        $monthlyStats = $this->getMonthlyStats();
        
        $users = User::where('role', 'user')->get();
        
        return view('admin.reports.index', compact(
            'totalEquipment',
            'availableEquipment',
            'activeEquipment',
            'categories',
            'equipmentUsage',
            'userActivity',
            'monthlyStats',
            'equipment',
            'users',
            'startDate',
            'endDate',
            'equipmentId',
            'userId'
        ));
    }

    private function getMonthlyStats()
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $months[] = [
                'month' => $month->format('M Y'),
                'equipment_added' => Equipment::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
                'users_registered' => User::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
                'total_inquiries' => rand(20, 80) // Simulasi data inquiries
            ];
        }
        return $months;
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        $equipmentId = $request->input('equipment_id');
        $userId = $request->input('user_id');
        
        // Generate CSV report
        $filename = 'laporan_equipment_' . $startDate . '_to_' . $endDate . '.csv';
        
        $equipment = Equipment::with('category');
        
        if ($equipmentId) {
            $equipment->where('id', $equipmentId);
        }
        
        $data = $equipment->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'ID',
                'Nama Alat',
                'Kategori',
                'Brand',
                'Model',
                'Tahun',
                'Stok',
                'Harga Sewa',
                'Status',
                'Dibuat Pada'
            ]);
            
            // Data CSV
            foreach ($data as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->name,
                    $item->category->name ?? '-',
                    $item->brand ?? '-',
                    $item->model ?? '-',
                    $item->manufacture_year ?? '-',
                    $item->stock,
                    'Rp ' . number_format($item->rental_price, 0, ',', '.'),
                    $item->is_active ? 'Aktif' : 'Tidak Aktif',
                    $item->created_at->format('d/m/Y H:i')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
