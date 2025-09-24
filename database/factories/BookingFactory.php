<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Create equipment if none exists
        $equipment = Equipment::count() > 0
            ? Equipment::inRandomOrder()->first()
            : Equipment::factory()->create();
            
        $startDate = $this->faker->dateTimeBetween('+1 day', '+1 month');
        $endDate = (clone $startDate)->modify('+' . $this->faker->numberBetween(1, 30) . ' days');
        
        // Calculate the difference in days
        $diff = $startDate->diff($endDate);
        $durationDays = $diff->days ?: 1; // Minimum 1 day
        
        $rentalPrice = $equipment->price_per_day;
        $totalPrice = $rentalPrice * $durationDays;
        
        return [
            'booking_code' => 'BK' . date('Ymd') . str_pad($this->faker->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT),
            'equipment_id' => $equipment->id,
            'customer_name' => $this->faker->name,
            'customer_email' => $this->faker->safeEmail,
            'customer_phone' => $this->faker->phoneNumber,
            'company_name' => $this->faker->company,
            'project_location' => $this->faker->address,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration_days' => $durationDays,
            'project_description' => $this->faker->paragraph,
            'special_requirements' => $this->faker->optional(0.7)->sentence,
            'rental_price' => $rentalPrice,
            'total_price' => $totalPrice,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'ongoing', 'completed', 'cancelled']),
        ];
    }

    /**
     * Set the booking status to pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Set the booking status to confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    /**
     * Set the booking status to ongoing.
     */
    public function ongoing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ongoing',
        ]);
    }

    /**
     * Set the booking status to completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }

    /**
     * Set the booking status to cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }
}