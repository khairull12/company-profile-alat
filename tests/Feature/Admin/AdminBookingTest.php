<?php

namespace Tests\Feature\Admin;

use App\Models\Booking;
use App\Models\Equipment;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBookingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that regular users cannot access admin booking management.
     */
    public function test_regular_users_cannot_access_admin_booking_management(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.bookings.index'));

        $response->assertStatus(403);
    }

    /**
     * Test that admin can access booking management.
     */
    public function test_admin_can_access_booking_management(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)
            ->get(route('admin.bookings.index'));

        $response->assertStatus(200)
            ->assertViewIs('admin.bookings.index');
    }

    /**
     * Test admin can view booking list.
     */
    public function test_admin_can_view_booking_list(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);
        $bookings = Booking::factory()->count(3)->create(['equipment_id' => $equipment->id]);

        $response = $this->actingAs($admin)
            ->get(route('admin.bookings.index'));

        $response->assertStatus(200);

        foreach ($bookings as $booking) {
            $response->assertSee($booking->booking_code);
        }
    }

    /**
     * Test admin can filter bookings by status.
     */
    public function test_admin_can_filter_bookings_by_status(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);
        
        // Create bookings with different statuses
        $pendingBooking = Booking::factory()->create([
            'equipment_id' => $equipment->id,
            'status' => 'pending'
        ]);
        
        $confirmedBooking = Booking::factory()->create([
            'equipment_id' => $equipment->id,
            'status' => 'confirmed'
        ]);
        
        $completedBooking = Booking::factory()->create([
            'equipment_id' => $equipment->id,
            'status' => 'completed'
        ]);

        // Test filtering by pending status
        $response = $this->actingAs($admin)
            ->get(route('admin.bookings.index', ['status' => 'pending']));

        $response->assertStatus(200)
            ->assertSee($pendingBooking->booking_code)
            ->assertDontSee($confirmedBooking->booking_code)
            ->assertDontSee($completedBooking->booking_code);

        // Test filtering by confirmed status
        $response = $this->actingAs($admin)
            ->get(route('admin.bookings.index', ['status' => 'confirmed']));

        $response->assertStatus(200)
            ->assertDontSee($pendingBooking->booking_code)
            ->assertSee($confirmedBooking->booking_code)
            ->assertDontSee($completedBooking->booking_code);
    }

    /**
     * Test admin can view booking details.
     */
    public function test_admin_can_view_booking_details(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);
        $booking = Booking::factory()->create(['equipment_id' => $equipment->id]);

        $response = $this->actingAs($admin)
            ->get(route('admin.bookings.show', $booking));

        $response->assertStatus(200)
            ->assertViewIs('admin.bookings.show')
            ->assertSee($booking->booking_code)
            ->assertSee($booking->customer_name)
            ->assertSee($equipment->name);
    }

    /**
     * Test admin can update booking status.
     */
    public function test_admin_can_update_booking_status(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);
        $booking = Booking::factory()->create([
            'equipment_id' => $equipment->id,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($admin)
            ->patch(route('admin.bookings.update-status', $booking), [
                'status' => 'confirmed'
            ]);

        $response->assertStatus(302)
            ->assertRedirect(route('admin.bookings.show', $booking))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'confirmed'
        ]);
    }

    /**
     * Test admin can filter bookings by date range.
     */
    public function test_admin_can_filter_bookings_by_date_range(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);
        
        // Create bookings with different dates
        $oldBooking = Booking::factory()->create([
            'equipment_id' => $equipment->id,
            'created_at' => now()->subMonth(),
        ]);
        
        $recentBooking = Booking::factory()->create([
            'equipment_id' => $equipment->id,
            'created_at' => now()->subDays(2),
        ]);

        // Test filtering by date range
        $response = $this->actingAs($admin)
            ->get(route('admin.bookings.index', [
                'start_date' => now()->subDays(3)->format('Y-m-d'),
                'end_date' => now()->format('Y-m-d')
            ]));

        $response->assertStatus(200)
            ->assertSee($recentBooking->booking_code)
            ->assertDontSee($oldBooking->booking_code);
    }

    /**
     * Test admin can search bookings by code or customer name.
     */
    public function test_admin_can_search_bookings(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);
        
        $booking1 = Booking::factory()->create([
            'equipment_id' => $equipment->id,
            'booking_code' => 'BK20250915001',
            'customer_name' => 'John Doe'
        ]);
        
        $booking2 = Booking::factory()->create([
            'equipment_id' => $equipment->id,
            'booking_code' => 'BK20250915002',
            'customer_name' => 'Jane Smith'
        ]);

        // Search by booking code
        $response = $this->actingAs($admin)
            ->get(route('admin.bookings.index', ['search' => 'BK20250915001']));

        $response->assertStatus(200)
            ->assertSee($booking1->booking_code)
            ->assertDontSee($booking2->booking_code);
            
        // Search by customer name
        $response = $this->actingAs($admin)
            ->get(route('admin.bookings.index', ['search' => 'Jane']));

        $response->assertStatus(200)
            ->assertSee($booking2->customer_name)
            ->assertDontSee($booking1->customer_name);
    }
}