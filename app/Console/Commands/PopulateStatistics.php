<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;

class PopulateStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate statistics settings in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting statistics population...');
        
        // Clear existing statistics settings first
        $deleted = Setting::where('group', 'statistics')->delete();
        $this->info("Deleted {$deleted} existing statistics settings");
        
        $statisticsSettings = [
            [
                'group' => 'statistics',
                'key' => 'total_equipment',
                'value' => '200+',
                'label' => 'Total Alat Berat',
                'description' => 'Unit tersedia siap beroperasi',
                'icon' => 'fas fa-tools'
            ],
            [
                'group' => 'statistics',
                'key' => 'completed_projects',
                'value' => '750+',
                'label' => 'Proyek Selesai',
                'description' => 'Proyek berhasil diselesaikan',
                'icon' => 'fas fa-project-diagram'
            ],
            [
                'group' => 'statistics',
                'key' => 'client_satisfaction',
                'value' => '99%',
                'label' => 'Kepuasan Klien',
                'description' => 'Tingkat kepuasan pelanggan',
                'icon' => 'fas fa-star'
            ],
            [
                'group' => 'statistics',
                'key' => 'years_experience',
                'value' => '15+',
                'label' => 'Pengalaman',
                'description' => 'Tahun melayani industri',
                'icon' => 'fas fa-calendar-alt'
            ]
        ];

        $created = 0;
        foreach ($statisticsSettings as $setting) {
            // Create main statistic value
            Setting::create([
                'group' => $setting['group'],
                'key' => $setting['key'],
                'value' => $setting['value'],
                'type' => 'text'
            ]);
            $created++;
            
            // Create label
            Setting::create([
                'group' => $setting['group'],
                'key' => $setting['key'] . '_label',
                'value' => $setting['label'],
                'type' => 'text'
            ]);
            $created++;
            
            // Create description
            Setting::create([
                'group' => $setting['group'],
                'key' => $setting['key'] . '_description',
                'value' => $setting['description'],
                'type' => 'text'
            ]);
            $created++;
            
            // Create icon
            Setting::create([
                'group' => $setting['group'],
                'key' => $setting['key'] . '_icon',
                'value' => $setting['icon'],
                'type' => 'text'
            ]);
            $created++;
            
            $this->info("Created settings for: {$setting['label']}");
        }

        $this->info("Successfully created {$created} statistics settings!");
        
        // Verify the creation
        $finalCount = Setting::where('group', 'statistics')->count();
        $this->info("Total statistics settings in database: {$finalCount}");
        
        return 0;
    }
}
