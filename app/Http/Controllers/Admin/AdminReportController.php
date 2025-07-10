<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Equipment;
use App\Models\User;
use App\Exports\BookingsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
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
        
        $query = Booking::with(['equipment', 'user'])
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        if ($equipmentId) {
            $query->where('equipment_id', $equipmentId);
        }
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        $bookings = $query->orderBy('created_at', 'desc')->get();
        
        // Statistics
        $totalBookings = $bookings->count();
        $confirmedBookings = $bookings->where('status', 'confirmed')->count();
        $completedBookings = $bookings->where('status', 'completed')->count();
        $totalRevenue = $bookings->where('status', 'completed')->sum('total_amount');
        
        // Equipment usage
        $equipmentUsage = $bookings->groupBy('equipment_id')
            ->map(function($group) {
                return [
                    'equipment' => $group->first()->equipment,
                    'total_bookings' => $group->count(),
                    'total_revenue' => $group->where('status', 'completed')->sum('total_amount')
                ];
            })
            ->sortByDesc('total_bookings');
        
        // User activity
        $userActivity = $bookings->groupBy('user_id')
            ->map(function($group) {
                return [
                    'user' => $group->first()->user,
                    'total_bookings' => $group->count(),
                    'total_spent' => $group->where('status', 'completed')->sum('total_amount')
                ];
            })
            ->sortByDesc('total_bookings');
        
        $equipment = Equipment::all();
        $users = User::users()->get();
        
        return view('admin.reports.index', compact(
            'bookings',
            'totalBookings',
            'confirmedBookings', 
            'completedBookings',
            'totalRevenue',
            'equipmentUsage',
            'userActivity',
            'equipment',
            'users',
            'startDate',
            'endDate',
            'equipmentId',
            'userId'
        ));
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        $equipmentId = $request->input('equipment_id');
        $userId = $request->input('user_id');
        $format = $request->input('format', 'excel');
        
        $filename = 'laporan_booking_' . $startDate . '_to_' . $endDate . '.xlsx';
        
        return Excel::download(
            new BookingsExport($startDate, $endDate, $equipmentId, $userId),
            $filename
        );
    }
}
