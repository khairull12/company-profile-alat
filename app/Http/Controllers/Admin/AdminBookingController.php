<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // Stats expected by Blade as `$stats[...]`
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'ongoing_bookings' => Booking::where('status', 'confirmed')->count(),
            'this_month_revenue' => Booking::where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_price'),
            'overdue_bookings' => Booking::where('status', 'confirmed')
                ->where('end_date', '<', now())
                ->count(),
        ];

        // Eloquent query with relations + optional filters
        $bookings = Booking::with(['equipment.category'])
            ->when(request('status'), function ($q) {
                $q->where('status', request('status'));
            })
            ->when(request('equipment_id'), function ($q) {
                $q->where('equipment_id', request('equipment_id'));
            })
            ->when(request('search'), function ($q) {
                $search = request('search');
                $q->where(function ($query) use ($search) {
                    $query->where('booking_code', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_email', 'like', "%{$search}%")
                        ->orWhere('customer_phone', 'like', "%{$search}%");
                });
            })
            ->when(request('start_date'), function ($q) {
                $q->whereDate('start_date', '>=', request('start_date'));
            })
            ->when(request('end_date'), function ($q) {
                $q->whereDate('end_date', '<=', request('end_date'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $equipment = Equipment::active()->with('category')->get();
        
        return view('admin.bookings.index', compact('bookings', 'equipment', 'stats'));
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
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'delivery_address' => 'nullable|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'nullable|string|max:1000',
            'admin_notes' => 'nullable|string|max:500',
            'total_cost' => 'required|numeric|min:0',
        ]);

        // Generate unique booking code
        $validated['booking_code'] = 'BK-' . strtoupper(Str::random(8));
        
        // Calculate duration
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $validated['duration_days'] = $startDate->diffInDays($endDate) + 1;

        // Map field names from form to database
        $validated['customer_email'] = $validated['contact_email'] ?? null;
        $validated['customer_phone'] = $validated['contact_phone'];
        $validated['project_location'] = $validated['delivery_address'] ?? null;
        $validated['project_description'] = $validated['notes'] ?? null;
        $validated['special_requirements'] = $validated['admin_notes'] ?? null;
        $validated['rental_price'] = $validated['total_cost'] / $validated['duration_days'];
        $validated['total_price'] = $validated['total_cost'];
        $validated['status'] = 'pending';

        Booking::create($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dicatat!');
    }

    public function show(Booking $booking)
    {
        $booking->load(['equipment.category', 'user']);
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
        DB::transaction(function () use ($booking) {
            // If a confirmed booking is removed, return stock
            if ($booking->status === 'confirmed') {
                $equipment = Equipment::find($booking->equipment_id);
                if ($equipment) {
                    $equipment->increaseStock($booking->quantity ?? 1);
                }
            }
            $booking->delete();
        });
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dihapus!');
    }
    
    /**
     * Update the booking status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,ongoing,completed,cancelled,active',
        ]);

        DB::transaction(function () use ($request, $booking) {
            $oldStatus = $booking->status;
            $newStatus = $request->status;
            // Map alias 'active' -> 'ongoing'
            if ($newStatus === 'active') {
                $newStatus = 'ongoing';
            }
            $qty = $booking->quantity ?? 1;

            $equipment = Equipment::find($booking->equipment_id);

            // On confirm, reduce stock (only once)
            if ($newStatus === 'confirmed' && $oldStatus !== 'confirmed' && $equipment) {
                if (!$equipment->hasStock($qty)) {
                    abort(400, 'Stok alat tidak mencukupi.');
                }
                $equipment->decreaseStock($qty);
            }

            // On completed or cancelled from confirmed, return stock
            if ($oldStatus === 'confirmed' && in_array($newStatus, ['completed', 'cancelled'], true) && $equipment) {
                $equipment->increaseStock($qty);
            }

            $booking->status = $newStatus;
            $booking->save();
        });
        
        
        return redirect()->back()->with('success', 'Status booking berhasil diperbarui.');
    }

    // Report method has been removed

    // Monthly Report method has been removed
}
