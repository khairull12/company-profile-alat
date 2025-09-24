<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Equipment;
use App\Http\Requests\StoreBookingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBookingController extends Controller
{
    public function index()
    {
        // Stats expected as `$stats[...]` in Blade
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

        // Eloquent query with relations for view access
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
            ->latest()
            ->paginate(10);

        $equipment = Equipment::active()->get();

        return view('admin.bookings.index', compact('bookings', 'equipment', 'stats'));
    }
    
    public function store(StoreBookingRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $equipment = Equipment::findOrFail($validated['equipment_id']);
            
            // Check if there's enough stock
            if (!$equipment->hasStock($validated['quantity'])) {
                return back()->with('error', 'Insufficient stock available for this equipment.');
            }

            // Create the booking
            $booking = Booking::create($validated);

            // Decrease the equipment stock
            $equipment->decreaseStock($validated['quantity']);

            DB::commit();

            return redirect()->route('admin.bookings.index')
                ->with('success', 'Booking created successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error creating booking: ' . $e->getMessage());
        }
    }

    public function destroy(Booking $booking)
    {
        try {
            DB::beginTransaction();

            // Get the equipment before deleting the booking
            $equipment = Equipment::findOrFail($booking->equipment_id);
            
            // Delete the booking
            $booking->delete();

            // Increase the equipment stock
            $equipment->increaseStock($booking->quantity);

            DB::commit();

            return redirect()->route('admin.bookings.index')
                ->with('success', 'Booking cancelled successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error cancelling booking: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        try {
            DB::beginTransaction();

            $oldStatus = $booking->status;
            $newStatus = $request->status;

            $equipment = Equipment::findOrFail($booking->equipment_id);

            // If changing to confirmed status, reduce stock
            if ($newStatus === 'confirmed' && $oldStatus !== 'confirmed') {
                if (!$equipment->hasStock($booking->quantity)) {
                    return back()->with('error', 'Insufficient stock available for this equipment.');
                }
                $equipment->decreaseStock($booking->quantity);
            }

            // If cancelling a confirmed booking or marking as completed, increase stock
            if (($oldStatus === 'confirmed') && ($newStatus === 'cancelled' || $newStatus === 'completed')) {
                $equipment->increaseStock($booking->quantity);
            }

            $booking->update(['status' => $newStatus]);

            DB::commit();

            return back()->with('success', 'Booking status updated successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error updating booking status: ' . $e->getMessage());
        }
    }
}