<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminBookingController extends Controller
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
        $query = Booking::with(['user', 'equipment']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('equipment')) {
            $query->where('equipment_id', $request->equipment);
        }
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        }
        
        $bookings = $query->orderBy('created_at', 'desc')->paginate(10);
        $equipment = Equipment::all();
        
        return view('admin.bookings.index', compact('bookings', 'equipment'));
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function confirm(Booking $booking)
    {
        $booking->update([
            'status' => 'confirmed',
            'confirmed_at' => Carbon::now(),
            'confirmed_by' => Auth::id()
        ]);
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dikonfirmasi.');
    }

    public function cancel(Request $request, Booking $booking)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500'
        ]);
        
        $booking->update([
            'status' => 'cancelled',
            'admin_notes' => $request->admin_notes
        ]);
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dibatalkan.');
    }

    public function complete(Booking $booking)
    {
        $booking->update([
            'status' => 'completed'
        ]);
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil diselesaikan.');
    }

    public function report(Request $request)
    {
        $query = Booking::with(['user', 'equipment']);
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $bookings = $query->orderBy('start_date', 'desc')->get();
        
        $totalBookings = $bookings->count();
        $totalRevenue = $bookings->where('status', 'completed')->sum('total_amount');
        $pendingBookings = $bookings->where('status', 'pending')->count();
        $confirmedBookings = $bookings->where('status', 'confirmed')->count();
        $cancelledBookings = $bookings->where('status', 'cancelled')->count();
        $completedBookings = $bookings->where('status', 'completed')->count();
        
        return view('admin.bookings.report', compact(
            'bookings',
            'totalBookings',
            'totalRevenue',
            'pendingBookings',
            'confirmedBookings',
            'cancelledBookings',
            'completedBookings'
        ));
    }
}
