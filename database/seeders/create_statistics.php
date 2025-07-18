<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->boot();

use App\Models\Setting;

// Clear existing statistics
Setting::where('group', 'statistics')->delete();

$statistics = [
    ['key' => 'total_equipment', 'value' => '200+', 'label' => 'Total Alat Berat', 'description' => 'Unit tersedia siap beroperasi', 'icon' => 'fas fa-tools'],
    ['key' => 'completed_projects', 'value' => '750+', 'label' => 'Proyek Selesai', 'description' => 'Proyek berhasil diselesaikan', 'icon' => 'fas fa-project-diagram'],
    ['key' => 'client_satisfaction', 'value' => '99%', 'label' => 'Kepuasan Klien', 'description' => 'Tingkat kepuasan pelanggan', 'icon' => 'fas fa-star'],
    ['key' => 'years_experience', 'value' => '15+', 'label' => 'Pengalaman', 'description' => 'Tahun melayani industri', 'icon' => 'fas fa-calendar-alt']
];

foreach ($statistics as $stat) {
    // Main value
    Setting::create([
        'group' => 'statistics',
        'key' => $stat['key'],
        'value' => $stat['value'],
        'type' => 'text'
    ]);
    
    // Label
    Setting::create([
        'group' => 'statistics',
        'key' => $stat['key'] . '_label',
        'value' => $stat['label'],
        'type' => 'text'
    ]);
    
    // Description
    Setting::create([
        'group' => 'statistics',
        'key' => $stat['key'] . '_description',
        'value' => $stat['description'],
        'type' => 'text'
    ]);
    
    // Icon
    Setting::create([
        'group' => 'statistics',
        'key' => $stat['key'] . '_icon',
        'value' => $stat['icon'],
        'type' => 'text'
    ]);
}

echo "Statistics settings created: " . Setting::where('group', 'statistics')->count() . " records\n";
