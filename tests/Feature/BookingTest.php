<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Equipment;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an authenticated user can see booking form.
     */
    public function test_authenticated_user_can_see_booking_form(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($user)
            ->get(route('equipment.show', $equipment));

        $response->assertStatus(200)
            ->assertViewIs('equipment.show')
            ->assertSee('Book This Equipment');
    }

    /**
     * Test that booking validation works for required fields.
     */
    public function test_booking_validation_fails_with_empty_fields(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($user)
            ->post(route('equipment.book', $equipment), [
                // No data provided to test validation
            ]);

        $response->assertStatus(302) // Redirected back to form
            ->assertSessionHasErrors(['customer_name', 'customer_email', 'customer_phone', 
                'start_date', 'end_date']);
    }

    /**
     * Test that booking validation works for dates.
     */
    public function test_booking_validation_fails_with_invalid_dates(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);

        // Past start date
        $response = $this->actingAs($user)
            ->post(route('equipment.book', $equipment), [
                'customer_name' => 'Test User',
                'customer_email' => 'test@example.com',
                'customer_phone' => '12345678',
                'company_name' => 'Test Company',
                'start_date' => now()->subDays(1)->format('Y-m-d'), // Yesterday
                'end_date' => now()->addDays(5)->format('Y-m-d'),
                'project_description' => 'Test project'
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors('start_date');

        // End date before start date
        $response = $this->actingAs($user)
            ->post(route('equipment.book', $equipment), [
                'customer_name' => 'Test User',
                'customer_email' => 'test@example.com',
                'customer_phone' => '12345678',
                'company_name' => 'Test Company',
                'start_date' => now()->addDays(5)->format('Y-m-d'),
                'end_date' => now()->addDays(2)->format('Y-m-d'), // Before start date
                'project_description' => 'Test project'
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors('end_date');
    }

    /**
     * Test successful booking creation.
     */
    public function test_successful_booking_creation(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);

        $startDate = now()->addDays(1)->format('Y-m-d');
        $endDate = now()->addDays(5)->format('Y-m-d');

        $response = $this->actingAs($user)
            ->post(route('equipment.book', $equipment), [
                'customer_name' => 'Test User',
                'customer_email' => 'test@example.com',
                'customer_phone' => '12345678',
                'company_name' => 'Test Company',
                'project_location' => 'Test Location',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'project_description' => 'Test project',
                'special_requirements' => 'None'
            ]);

        // Assert that booking was created and redirect to confirmation
        $response->assertStatus(302)
            ->assertRedirect(route('booking.confirmation'));

        // Check database has the booking
        $this->assertDatabaseHas('bookings', [
            'customer_name' => 'Test User',
            'customer_email' => 'test@example.com',
            'equipment_id' => $equipment->id,
            'status' => 'pending' // Initial status
        ]);
    }

    /**
     * Test cannot book inactive equipment.
     */
    public function test_cannot_book_inactive_equipment(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create([
            'category_id' => $category->id,
            'is_active' => false
        ]);

        $response = $this->actingAs($user)
            ->post(route('equipment.book', $equipment), [
                'customer_name' => 'Test User',
                'customer_email' => 'test@example.com',
                'customer_phone' => '12345678',
                'company_name' => 'Test Company',
                'project_location' => 'Test Location',
                'start_date' => now()->addDays(1)->format('Y-m-d'),
                'end_date' => now()->addDays(5)->format('Y-m-d'),
                'project_description' => 'Test project'
            ]);

        $response->assertStatus(404);

        // Verify no booking was created
        $this->assertDatabaseMissing('bookings', [
            'customer_name' => 'Test User',
            'equipment_id' => $equipment->id
        ]);
    }

    /**
     * Test cannot book out of stock equipment.
     */
    public function test_cannot_book_out_of_stock_equipment(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create([
            'category_id' => $category->id,
            'stock' => 0
        ]);

        $response = $this->actingAs($user)
            ->post(route('equipment.book', $equipment), [
                'customer_name' => 'Test User',
                'customer_email' => 'test@example.com',
                'customer_phone' => '12345678',
                'company_name' => 'Test Company',
                'project_location' => 'Test Location',
                'start_date' => now()->addDays(1)->format('Y-m-d'),
                'end_date' => now()->addDays(5)->format('Y-m-d'),
                'project_description' => 'Test project'
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['equipment' => 'This equipment is currently unavailable.']);
    }

    /**
     * Test booking confirmation page displays.
     */
    public function test_booking_confirmation_page_displays(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);
        
        // Create a booking first
        $booking = Booking::factory()->create([
            'equipment_id' => $equipment->id,
            'customer_email' => $user->email
        ]);
        
        // Store booking in session
        session(['last_booking_id' => $booking->id]);
        
        $response = $this->actingAs($user)
            ->get(route('booking.confirmation'));
            
        $response->assertStatus(200)
            ->assertViewIs('booking.confirmation')
            ->assertSee($booking->booking_code)
            ->assertSee($equipment->name);
    }

    /**
     * Test user can view their booking history.
     */
    public function test_user_can_view_booking_history(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);
        
        // Create bookings with the user's email
        $bookings = Booking::factory()->count(3)->create([
            'equipment_id' => $equipment->id,
            'customer_email' => $user->email
        ]);
        
        $response = $this->actingAs($user)
            ->get(route('user.bookings'));
            
        $response->assertStatus(200)
            ->assertViewIs('user.bookings');
            
        foreach ($bookings as $booking) {
            $response->assertSee($booking->booking_code);
        }
    }

    /**
     * Test user can view a specific booking.
     */
    public function test_user_can_view_specific_booking(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);
        
        $booking = Booking::factory()->create([
            'equipment_id' => $equipment->id,
            'customer_email' => $user->email
        ]);
        
        $response = $this->actingAs($user)
            ->get(route('user.bookings.show', $booking));
            
        $response->assertStatus(200)
            ->assertViewIs('user.bookings.show')
            ->assertSee($booking->booking_code)
            ->assertSee($equipment->name)
            ->assertSee($booking->start_date->format('d-m-Y'))
            ->assertSee($booking->end_date->format('d-m-Y'));
    }
}