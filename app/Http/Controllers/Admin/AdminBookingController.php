<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $bookings = Booking::with(['equipment.category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $equipment = Equipment::active()->with('category')->get();
        return view('admin.bookings.create', compact('equipment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'project_location' => 'required|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'project_description' => 'required|string|max:1000',
            'special_requirements' => 'nullable|string|max:500',
            'rental_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,ongoing,completed,cancelled',
        ]);

        // Generate unique booking code
        $validated['booking_code'] = 'BK-' . strtoupper(Str::random(8));
        
        // Calculate duration
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $validated['duration_days'] = $startDate->diffInDays($endDate) + 1;

        // Calculate total price
        $validated['total_price'] = $validated['rental_price'] * $validated['duration_days'];

        Booking::create($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dicatat!');
    }

    public function show(Booking $booking)
    {
        $booking->load(['equipment.category']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $equipment = Equipment::active()->with('category')->get();
        return view('admin.bookings.edit', compact('booking', 'equipment'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'project_location' => 'required|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'project_description' => 'required|string|max:1000',
            'special_requirements' => 'nullable|string|max:500',
            'rental_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,ongoing,completed,cancelled',
        ]);

        // Calculate duration
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $validated['duration_days'] = $startDate->diffInDays($endDate) + 1;

        // Calculate total price
        $validated['total_price'] = $validated['rental_price'] * $validated['duration_days'];

        $booking->update($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil diupdate!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dihapus!');
    }

    public function report(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        $status = $request->input('status');

        $query = Booking::with(['equipment.category'])
            ->whereBetween('start_date', [$startDate, $endDate]);

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->orderBy('start_date', 'desc')->get();

        $summary = [
            'total_bookings' => $bookings->count(),
            'total_revenue' => $bookings->sum('total_price'),
            'avg_duration' => $bookings->avg('duration_days') ? round($bookings->avg('duration_days'), 1) : 0,
            'total_equipment_used' => $bookings->pluck('equipment_id')->unique()->count(),
            'by_status' => $bookings->groupBy('status')->map->count(),
        ];

        return view('admin.bookings.report', compact('bookings', 'summary', 'startDate', 'endDate'));
    }

    public function monthlyReport(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);
        
        // Get start and end dates for the selected month
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        // Get bookings for the selected month
        $bookings = Booking::with(['equipment.category'])
            ->whereBetween('start_date', [$startDate, $endDate])
            ->orderBy('start_date', 'desc')
            ->get();

        // Calculate monthly statistics
        $monthlyStats = [
            'total_bookings' => $bookings->count(),
            'completed_bookings' => $bookings->where('status', 'completed')->count(),
            'cancelled_bookings' => $bookings->where('status', 'cancelled')->count(),
            'ongoing_bookings' => $bookings->where('status', 'ongoing')->count(),
            'total_revenue' => $bookings->where('status', 'completed')->sum('total_price'),
            'pending_revenue' => $bookings->whereIn('status', ['confirmed', 'ongoing'])->sum('total_price'),
            'avg_booking_value' => $bookings->avg('total_price') ? round($bookings->avg('total_price'), 0) : 0,
            'avg_duration' => $bookings->avg('duration_days') ? round($bookings->avg('duration_days'), 1) : 0,
        ];

        // Get equipment usage statistics
        $equipmentStats = $bookings->groupBy('equipment_id')
            ->map(function ($equipmentBookings) {
                $equipment = $equipmentBookings->first()->equipment;
                return [
                    'equipment' => $equipment,
                    'bookings_count' => $equipmentBookings->count(),
                    'total_revenue' => $equipmentBookings->where('status', 'completed')->sum('total_price'),
                    'total_days' => $equipmentBookings->sum('duration_days'),
                ];
            })
            ->sortByDesc('bookings_count');

        // Get year and month options for the filter
        $yearOptions = range(now()->year - 2, now()->year + 1);
        $monthOptions = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return view('admin.bookings.monthly-report', compact(
            'bookings', 
            'monthlyStats', 
            'equipmentStats',
            'year', 
            'month', 
            'yearOptions', 
            'monthOptions',
            'startDate',
            'endDate'
        ));
    }
}
