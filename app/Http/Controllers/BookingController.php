<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookings = Booking::with(['equipment', 'user'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('bookings.index', compact('bookings'));
    }

    public function create(Equipment $equipment)
    {
        return view('bookings.create', compact('equipment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'notes' => 'nullable|string|max:500'
        ]);

        $equipment = Equipment::findOrFail($request->equipment_id);
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        
        // Check availability
        if (!$equipment->isAvailableForPeriod($startDate, $endDate)) {
            return back()->with('error', 'Alat tidak tersedia untuk periode yang dipilih.');
        }

        $durationDays = $startDate->diffInDays($endDate) + 1;
        $totalAmount = $durationDays * $equipment->price_per_day;

        Booking::create([
            'user_id' => Auth::id(),
            'equipment_id' => $equipment->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration_days' => $durationDays,
            'daily_rate' => $equipment->price_per_day,
            'total_amount' => $totalAmount,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking berhasil dibuat. Menunggu konfirmasi admin.');
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('bookings.show', compact('booking'));
    }

    public function checkAvailability(Request $request)
    {
        $equipment = Equipment::findOrFail($request->equipment_id);
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        
        $isAvailable = $equipment->isAvailableForPeriod($startDate, $endDate);
        $durationDays = $startDate->diffInDays($endDate) + 1;
        $totalAmount = $durationDays * $equipment->price_per_day;
        
        return response()->json([
            'available' => $isAvailable,
            'duration_days' => $durationDays,
            'daily_rate' => $equipment->price_per_day,
            'total_amount' => $totalAmount
        ]);
    }
}
