<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class StatisticsSettingSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Clear existing statistics settings first
        Setting::where('group', 'statistics')->delete();
        
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

        foreach ($statisticsSettings as $setting) {
            // Create main statistic value
            Setting::create([
                'group' => $setting['group'],
                'key' => $setting['key'],
                'value' => $setting['value'],
                'type' => 'text'
            ]);
            
            // Create label
            Setting::create([
                'group' => $setting['group'],
                'key' => $setting['key'] . '_label',
                'value' => $setting['label'],
                'type' => 'text'
            ]);
            
            // Create description
            Setting::create([
                'group' => $setting['group'],
                'key' => $setting['key'] . '_description',
                'value' => $setting['description'],
                'type' => 'text'
            ]);
            
            // Create icon
            Setting::create([
                'group' => $setting['group'],
                'key' => $setting['key'] . '_icon',
                'value' => $setting['icon'],
                'type' => 'text'
            ]);
        }
    }
}

