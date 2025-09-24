<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EquipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Equipment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);
        $slug = Str::slug($name);
        
        // Create a default category if none exists
        $category = Category::count() > 0
            ? Category::inRandomOrder()->first()->id
            : Category::factory()->create()->id;
            
        return [
            'name' => ucfirst($name),
            'slug' => $slug,
            'description' => $this->faker->paragraphs(2, true),
            'price_per_day' => $this->faker->numberBetween(50, 1000) * 10000,
            'stock' => $this->faker->numberBetween(1, 5),
            'brand' => $this->faker->company,
            'model' => Str::upper($this->faker->bothify('???-####')),
            'manufacture_year' => $this->faker->numberBetween(2010, 2024),
            'specifications' => json_encode([
                'Power' => $this->faker->numberBetween(100, 500) . ' HP',
                'Weight' => $this->faker->numberBetween(1, 20) . ' Ton',
                'Dimensions' => $this->faker->numberBetween(5, 15) . 'm x ' . 
                                $this->faker->numberBetween(2, 5) . 'm x ' . 
                                $this->faker->numberBetween(2, 5) . 'm',
                'Fuel Type' => $this->faker->randomElement(['Diesel', 'Biodiesel', 'Electric']),
                'Max Capacity' => $this->faker->numberBetween(5, 50) . ' Ton',
            ]),
            'images' => ['default-equipment.jpg'],
            'category_id' => $category,
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the equipment is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the equipment is out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 0,
        ]);
    }
}