<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test equipment index page displays correctly.
     */
    public function test_equipment_index_page_loads_successfully(): void
    {
        $response = $this->get(route('equipment.index'));

        $response->assertStatus(200)
            ->assertViewIs('equipment.index')
            ->assertSee('Equipment');
    }

    /**
     * Test equipment index page displays equipment.
     */
    public function test_equipment_index_page_displays_equipment(): void
    {
        // Create some equipment with factory
        $category = Category::factory()->create();
        $equipment = Equipment::factory()
            ->count(3)
            ->create(['category_id' => $category->id]);

        $response = $this->get(route('equipment.index'));

        // Check response and see if equipment names are displayed
        $response->assertStatus(200);
        
        foreach ($equipment as $item) {
            $response->assertSee($item->name);
        }
    }

    /**
     * Test inactive equipment is not displayed on index page.
     */
    public function test_inactive_equipment_not_displayed_on_index_page(): void
    {
        $category = Category::factory()->create();
        
        // Create active equipment
        $activeEquipment = Equipment::factory()->create([
            'category_id' => $category->id,
            'is_active' => true
        ]);
        
        // Create inactive equipment
        $inactiveEquipment = Equipment::factory()->create([
            'category_id' => $category->id,
            'is_active' => false
        ]);

        $response = $this->get(route('equipment.index'));

        $response->assertStatus(200)
            ->assertSee($activeEquipment->name)
            ->assertDontSee($inactiveEquipment->name);
    }

    /**
     * Test equipment detail page loads successfully.
     */
    public function test_equipment_detail_page_loads_successfully(): void
    {
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);

        $response = $this->get(route('equipment.show', $equipment));

        $response->assertStatus(200)
            ->assertViewIs('equipment.show')
            ->assertSee($equipment->name)
            ->assertSee($equipment->description)
            ->assertSee(number_format($equipment->price_per_day));
    }

    /**
     * Test inactive equipment detail page returns 404.
     */
    public function test_inactive_equipment_detail_page_returns_404(): void
    {
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create([
            'category_id' => $category->id,
            'is_active' => false
        ]);

        $response = $this->get(route('equipment.show', $equipment));

        $response->assertStatus(404);
    }

    /**
     * Test equipment filtering by category works correctly.
     */
    public function test_equipment_filtering_by_category_works(): void
    {
        // Create categories
        $category1 = Category::factory()->create(['name' => 'Excavators']);
        $category2 = Category::factory()->create(['name' => 'Bulldozers']);
        
        // Create equipment in different categories
        $equipment1 = Equipment::factory()->create([
            'name' => 'Excavator Model X',
            'category_id' => $category1->id
        ]);
        
        $equipment2 = Equipment::factory()->create([
            'name' => 'Bulldozer Model Y',
            'category_id' => $category2->id
        ]);

        // Test filter by first category
        $response = $this->get(route('equipment.index', ['category' => $category1->slug]));
        
        $response->assertStatus(200)
            ->assertSee($equipment1->name)
            ->assertDontSee($equipment2->name);
            
        // Test filter by second category
        $response = $this->get(route('equipment.index', ['category' => $category2->slug]));
        
        $response->assertStatus(200)
            ->assertSee($equipment2->name)
            ->assertDontSee($equipment1->name);
    }

    /**
     * Test equipment search functionality works.
     */
    public function test_equipment_search_works(): void
    {
        $category = Category::factory()->create();
        
        // Create equipment with specific names
        $equipment1 = Equipment::factory()->create([
            'name' => 'Excavator Giant 3000',
            'category_id' => $category->id
        ]);
        
        $equipment2 = Equipment::factory()->create([
            'name' => 'Bulldozer Small 1000',
            'category_id' => $category->id
        ]);

        // Search for "excavator"
        $response = $this->get(route('equipment.index', ['search' => 'excavator']));
        
        $response->assertStatus(200)
            ->assertSee($equipment1->name)
            ->assertDontSee($equipment2->name);
            
        // Search for "bulldozer"
        $response = $this->get(route('equipment.index', ['search' => 'bulldozer']));
        
        $response->assertStatus(200)
            ->assertSee($equipment2->name)
            ->assertDontSee($equipment1->name);
    }
}