<?php

namespace Tests\Feature\Admin;

use App\Models\Equipment;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminEquipmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that regular users cannot access admin equipment management.
     */
    public function test_regular_users_cannot_access_admin_equipment_management(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.equipment.index'));

        $response->assertStatus(403);
    }

    /**
     * Test that admin can access equipment management.
     */
    public function test_admin_can_access_equipment_management(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)
            ->get(route('admin.equipment.index'));

        $response->assertStatus(200)
            ->assertViewIs('admin.equipment.index');
    }

    /**
     * Test admin can view equipment list.
     */
    public function test_admin_can_view_equipment_list(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->count(3)->create(['category_id' => $category->id]);

        $response = $this->actingAs($admin)
            ->get(route('admin.equipment.index'));

        $response->assertStatus(200);

        foreach ($equipment as $item) {
            $response->assertSee($item->name);
        }
    }

    /**
     * Test admin can access create equipment page.
     */
    public function test_admin_can_access_create_equipment_page(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)
            ->get(route('admin.equipment.create'));

        $response->assertStatus(200)
            ->assertViewIs('admin.equipment.create')
            ->assertSee('Add New Equipment');
    }

    /**
     * Test admin can create new equipment.
     */
    public function test_admin_can_create_new_equipment(): void
    {
        Storage::fake('public');
        
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        
        $image = UploadedFile::fake()->image('equipment.jpg');

        $response = $this->actingAs($admin)
            ->post(route('admin.equipment.store'), [
                'name' => 'New Test Equipment',
                'slug' => 'new-test-equipment',
                'description' => 'This is a test equipment description',
                'price_per_day' => 500000,
                'stock' => 5,
                'brand' => 'Test Brand',
                'model' => 'TEST-2025',
                'manufacture_year' => 2025,
                'category_id' => $category->id,
                'specifications' => [
                    'Power' => '300 HP',
                    'Weight' => '10 Ton',
                    'Dimensions' => '10m x 3m x 4m',
                ],
                'images' => [$image],
                'is_active' => true
            ]);

        $response->assertStatus(302)
            ->assertRedirect(route('admin.equipment.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('equipment', [
            'name' => 'New Test Equipment',
            'stock' => 5,
            'category_id' => $category->id,
        ]);
        
        // Verify image was stored
        Storage::disk('public')->assertExists('equipment/' . $image->hashName());
    }

    /**
     * Test admin can edit equipment.
     */
    public function test_admin_can_edit_equipment(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($admin)
            ->get(route('admin.equipment.edit', $equipment));

        $response->assertStatus(200)
            ->assertViewIs('admin.equipment.edit')
            ->assertSee($equipment->name)
            ->assertSee('Edit Equipment');
    }

    /**
     * Test admin can update equipment.
     */
    public function test_admin_can_update_equipment(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($admin)
            ->put(route('admin.equipment.update', $equipment), [
                'name' => 'Updated Equipment Name',
                'slug' => 'updated-equipment-name',
                'description' => 'Updated description',
                'price_per_day' => $equipment->price_per_day,
                'stock' => $equipment->stock,
                'brand' => $equipment->brand,
                'model' => $equipment->model,
                'manufacture_year' => $equipment->manufacture_year,
                'category_id' => $category->id,
                'specifications' => $equipment->specifications,
                'is_active' => $equipment->is_active
            ]);

        $response->assertStatus(302)
            ->assertRedirect(route('admin.equipment.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('equipment', [
            'id' => $equipment->id,
            'name' => 'Updated Equipment Name',
            'description' => 'Updated description'
        ]);
    }

    /**
     * Test admin can delete equipment.
     */
    public function test_admin_can_delete_equipment(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($admin)
            ->delete(route('admin.equipment.destroy', $equipment));

        $response->assertStatus(302)
            ->assertRedirect(route('admin.equipment.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('equipment', [
            'id' => $equipment->id
        ]);
    }

    /**
     * Test equipment validation fails with missing required fields.
     */
    public function test_equipment_validation_fails_with_missing_fields(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)
            ->post(route('admin.equipment.store'), [
                // Missing required fields
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['name', 'price_per_day', 'category_id']);
    }
}