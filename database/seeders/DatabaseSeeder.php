<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\EquipmentDataUpdate2025;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            CategorySeeder::class,
            EquipmentDataUpdate2025::class, // Menggunakan data katalog terbaru
            SettingSeeder::class,
            StatisticsSettingSeeder::class,
        ]);
    }
}
