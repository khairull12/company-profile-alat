<?php

namespace Tests\Feature\Admin;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminSettingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that regular users cannot access admin settings management.
     */
    public function test_regular_users_cannot_access_admin_settings(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.settings.index'));

        $response->assertStatus(403);
    }

    /**
     * Test that admin can access settings management.
     */
    public function test_admin_can_access_settings(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)
            ->get(route('admin.settings.index'));

        $response->assertStatus(200)
            ->assertViewIs('admin.settings.index');
    }
    
    /**
     * Test admin can update company settings.
     */
    public function test_admin_can_update_company_settings(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        
        // Create company settings first
        Setting::create(['key' => 'company_name', 'value' => 'Old Company Name', 'group' => 'company']);
        Setting::create(['key' => 'company_address', 'value' => 'Old Address', 'group' => 'company']);
        Setting::create(['key' => 'company_email', 'value' => 'old@example.com', 'group' => 'company']);
        Setting::create(['key' => 'company_phone', 'value' => '123456789', 'group' => 'company']);
        
        $response = $this->actingAs($admin)
            ->put(route('admin.settings.update', 'company'), [
                'company_name' => 'New Company Name',
                'company_address' => 'New Address, City',
                'company_email' => 'new@example.com',
                'company_phone' => '987654321'
            ]);

        $response->assertStatus(302)
            ->assertRedirect(route('admin.settings.edit', 'company'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('settings', [
            'key' => 'company_name', 
            'value' => 'New Company Name'
        ]);
        
        $this->assertDatabaseHas('settings', [
            'key' => 'company_email',
            'value' => 'new@example.com'
        ]);
    }
    
    /**
     * Test admin can update logo.
     */
    public function test_admin_can_upload_company_logo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        
        $logo = UploadedFile::fake()->image('logo.png', 200, 60);
        
        $response = $this->actingAs($admin)
            ->post(route('admin.settings.upload-image'), [
                'image' => $logo,
                'type' => 'logo'
            ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
            
        // Verify image was stored
        Storage::disk('public')->assertExists('images/' . $logo->hashName());
        
        // Verify setting was stored
        $this->assertDatabaseHas('settings', [
            'key' => 'company_logo',
            'group' => 'images'
        ]);
    }
    
    /**
     * Test admin can update statistics settings.
     */
    public function test_admin_can_update_statistics_settings(): void
    {
        $admin = User::factory()->admin()->create();
        
        // Create statistics settings
        Setting::create(['key' => 'show_statistics', 'value' => '0', 'group' => 'statistics']);
        Setting::create(['key' => 'completed_projects', 'value' => '50', 'group' => 'statistics']);
        Setting::create(['key' => 'happy_clients', 'value' => '100', 'group' => 'statistics']);
        
        $response = $this->actingAs($admin)
            ->put(route('admin.settings.statistics.update'), [
                'show_statistics' => '1',
                'completed_projects' => '75',
                'happy_clients' => '150',
                'equipment_count' => '30'
            ]);

        $response->assertStatus(302)
            ->assertRedirect(route('admin.settings.statistics'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('settings', [
            'key' => 'show_statistics', 
            'value' => '1'
        ]);
        
        $this->assertDatabaseHas('settings', [
            'key' => 'completed_projects',
            'value' => '75'
        ]);
        
        $this->assertDatabaseHas('settings', [
            'key' => 'equipment_count',
            'value' => '30'
        ]);
    }
    
    /**
     * Test admin can create new setting.
     */
    public function test_admin_can_create_new_setting(): void
    {
        $admin = User::factory()->admin()->create();
        
        $response = $this->actingAs($admin)
            ->post(route('admin.settings.store'), [
                'key' => 'new_setting_key',
                'value' => 'New Setting Value',
                'group' => 'custom'
            ]);

        $response->assertStatus(302)
            ->assertRedirect(route('admin.settings.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('settings', [
            'key' => 'new_setting_key',
            'value' => 'New Setting Value',
            'group' => 'custom'
        ]);
    }
    
    /**
     * Test admin can delete setting.
     */
    public function test_admin_can_delete_setting(): void
    {
        $admin = User::factory()->admin()->create();
        
        // Create a setting to delete
        $setting = Setting::create([
            'key' => 'delete_me',
            'value' => 'Delete Me',
            'group' => 'custom'
        ]);
        
        $response = $this->actingAs($admin)
            ->delete(route('admin.settings.destroy', $setting->id));

        $response->assertStatus(302)
            ->assertRedirect(route('admin.settings.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('settings', [
            'id' => $setting->id
        ]);
    }
    
    /**
     * Test settings validation fails with invalid data.
     */
    public function test_settings_validation_fails_with_invalid_data(): void
    {
        $admin = User::factory()->admin()->create();
        
        $response = $this->actingAs($admin)
            ->post(route('admin.settings.store'), [
                // Missing key and group
                'value' => 'Just a value'
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['key', 'group']);
    }
}