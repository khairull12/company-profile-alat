<?php

namespace Tests\Feature;

use App\Models\Equipment;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test home page loads successfully.
     */
    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200)
            ->assertViewIs('home');
    }

    /**
     * Test home page displays featured equipment.
     */
    public function test_home_page_displays_featured_equipment(): void
    {
        $category = Category::factory()->create();
        $equipment = Equipment::factory()->count(3)->create([
            'category_id' => $category->id,
            'is_active' => true
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        
        foreach ($equipment as $item) {
            $response->assertSee($item->name);
        }
    }

    /**
     * Test home page displays company information from settings.
     */
    public function test_home_page_displays_company_info(): void
    {
        // Create settings
        Setting::create(['key' => 'company_name', 'value' => 'Test Company', 'group' => 'company']);
        Setting::create(['key' => 'company_tagline', 'value' => 'Best Equipment Rental', 'group' => 'company']);
        
        $response = $this->get(route('home'));

        $response->assertStatus(200)
            ->assertSee('Test Company')
            ->assertSee('Best Equipment Rental');
    }

    /**
     * Test home page displays statistics if enabled.
     */
    public function test_home_page_displays_statistics_if_enabled(): void
    {
        // Create statistics settings with enabled stats
        Setting::create(['key' => 'show_statistics', 'value' => '1', 'group' => 'statistics']);
        Setting::create(['key' => 'completed_projects', 'value' => '100', 'group' => 'statistics']);
        Setting::create(['key' => 'happy_clients', 'value' => '50', 'group' => 'statistics']);
        Setting::create(['key' => 'equipment_count', 'value' => '30', 'group' => 'statistics']);
        
        $response = $this->get(route('home'));

        $response->assertStatus(200)
            ->assertSee('100')
            ->assertSee('50')
            ->assertSee('30');
    }

    /**
     * Test home page doesn't display statistics if disabled.
     */
    public function test_home_page_hides_statistics_if_disabled(): void
    {
        // Create statistics settings with disabled stats
        Setting::create(['key' => 'show_statistics', 'value' => '0', 'group' => 'statistics']);
        Setting::create(['key' => 'completed_projects', 'value' => '100', 'group' => 'statistics']);
        
        $response = $this->get(route('home'));

        // The statistics section should not be present
        $response->assertStatus(200)
            ->assertDontSee('completed_projects')
            ->assertDontSee('100');
    }

    /**
     * Test about page loads successfully.
     */
    public function test_about_page_loads_successfully(): void
    {
        $response = $this->get(route('about'));

        $response->assertStatus(200)
            ->assertViewIs('about');
    }

    /**
     * Test vision mission page loads successfully.
     */
    public function test_vision_mission_page_loads_successfully(): void
    {
        $response = $this->get(route('vision-mission'));

        $response->assertStatus(200)
            ->assertViewIs('vision-mission');
    }

    /**
     * Test contact page loads successfully.
     */
    public function test_contact_page_loads_successfully(): void
    {
        $response = $this->get(route('contact'));

        $response->assertStatus(200)
            ->assertViewIs('contact');
    }

    /**
     * Test about page displays company description from settings.
     */
    public function test_about_page_displays_company_description(): void
    {
        // Create about us content in settings
        Setting::create([
            'key' => 'about_content', 
            'value' => 'This is our company history and description.', 
            'group' => 'content'
        ]);
        
        $response = $this->get(route('about'));

        $response->assertStatus(200)
            ->assertSee('This is our company history and description.');
    }

    /**
     * Test vision mission page displays content from settings.
     */
    public function test_vision_mission_page_displays_content(): void
    {
        // Create vision mission content in settings
        Setting::create([
            'key' => 'vision_content', 
            'value' => 'Our vision is to be the leading equipment rental company.', 
            'group' => 'content'
        ]);
        
        Setting::create([
            'key' => 'mission_content', 
            'value' => 'Our mission is to provide high-quality equipment rental services.', 
            'group' => 'content'
        ]);
        
        $response = $this->get(route('vision-mission'));

        $response->assertStatus(200)
            ->assertSee('Our vision is to be the leading equipment rental company.')
            ->assertSee('Our mission is to provide high-quality equipment rental services.');
    }

    /**
     * Test contact page displays company contact information.
     */
    public function test_contact_page_displays_company_contact_info(): void
    {
        // Create contact information in settings
        Setting::create(['key' => 'company_email', 'value' => 'contact@example.com', 'group' => 'company']);
        Setting::create(['key' => 'company_phone', 'value' => '+62123456789', 'group' => 'company']);
        Setting::create(['key' => 'company_address', 'value' => 'Test Address, City, Country', 'group' => 'company']);
        
        $response = $this->get(route('contact'));

        $response->assertStatus(200)
            ->assertSee('contact@example.com')
            ->assertSee('+62123456789')
            ->assertSee('Test Address, City, Country');
    }
}