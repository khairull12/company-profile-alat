<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EquipmentDataUpdate2025 extends Seeder
{
    /**
     * Run the database seeds.
     * Update data berdasarkan katalog alat terbaru
     */
    public function run(): void
    {
        // Nonaktifkan foreign key checks sementara
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Hapus data equipment lama
        Equipment::truncate();
        
        // Aktifkan kembali foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Ambil kategori yang ada
        $excavatorCategory = Category::where('slug', 'excavator')->firstOrFail();
        $bulldozerCategory = Category::where('slug', 'bulldozer')->firstOrFail();
        $trontonCategory = Category::where('slug', 'tronton')->firstOrFail();
        $loaderCategory = Category::where('slug', 'loader')->firstOrFail();
        $craneCategory = Category::where('slug', 'crane')->first();

        // Data equipment baru berdasarkan katalog
        $equipment = [
            // 1. Sumitomo PC 200
            [
                'name' => 'Sumitomo PC 200',
                'slug' => 'sumitomo-pc-200',
                'description' => 'Excavator serbaguna untuk pekerjaan galian dan konstruksi. Cocok untuk proyek jalan, jembatan, dan perkebunan.',
                'price_per_day' => 2300000,
                'stock' => 1,
                'brand' => 'Sumitomo',
                'model' => 'PC 200',
                'manufacture_year' => 2017,
                'specifications' => [
                    'kapasitas_bucket' => '0.8 m³',
                    'berat_operasi' => '20 ton',
                    'tenaga_mesin' => '140 HP',
                    'jangkauan_max' => '9.5 meter',
                    'kedalaman_galian_max' => '6.8 meter'
                ],
                'category_id' => $excavatorCategory->id,
                'is_active' => true
            ],
            
            // 2. SANY PC 200
            [
                'name' => 'SANY PC 200',
                'slug' => 'sany-pc-200',
                'description' => 'Excavator kelas menengah dengan efisiensi tinggi, digunakan untuk konstruksi umum dan tambang ringan.',
                'price_per_day' => 2200000,
                'stock' => 4,
                'brand' => 'SANY',
                'model' => 'PC 200',
                'manufacture_year' => null, // tidak disebutkan di katalog
                'specifications' => [
                    'kapasitas_bucket' => '1.0 m³',
                    'berat_operasi' => '20 ton',
                    'tenaga_mesin' => '148 HP',
                    'jangkauan_max' => '9.8 meter',
                    'kedalaman_galian_max' => '6.6 meter'
                ],
                'category_id' => $excavatorCategory->id,
                'is_active' => true
            ],
            
            // 3. Hyundai PC 215
            [
                'name' => 'Hyundai PC 215',
                'slug' => 'hyundai-pc-215',
                'description' => 'Excavator modern dengan sistem hidrolik canggih, cocok untuk pekerjaan berat di pertambangan dan proyek besar.',
                'price_per_day' => 2500000,
                'stock' => 6,
                'brand' => 'Hyundai',
                'model' => 'PC 215',
                'manufacture_year' => 2021,
                'specifications' => [
                    'kapasitas_bucket' => '1.2 m³',
                    'berat_operasi' => '21.5 ton',
                    'tenaga_mesin' => '157 HP',
                    'jangkauan_max' => '10.2 meter',
                    'kedalaman_galian_max' => '7.2 meter'
                ],
                'category_id' => $excavatorCategory->id,
                'is_active' => true
            ],
            
            // 4. Liugong PC 200
            [
                'name' => 'Liugong PC 200',
                'slug' => 'liugong-pc-200',
                'description' => 'Excavator terbaru, hemat bahan bakar dan ramah lingkungan, dengan performa tinggi di segala medan.',
                'price_per_day' => 2400000,
                'stock' => 5,
                'brand' => 'Liugong',
                'model' => 'PC 200',
                'manufacture_year' => 2024,
                'specifications' => [
                    'kapasitas_bucket' => '1.0 m³',
                    'berat_operasi' => '20 ton',
                    'tenaga_mesin' => '150 HP',
                    'jangkauan_max' => '9.8 meter',
                    'kedalaman_galian_max' => '6.7 meter'
                ],
                'category_id' => $excavatorCategory->id,
                'is_active' => true
            ],
            
            // 5. Long Arm SANY PC 200
            [
                'name' => 'Long Arm SANY PC 200',
                'slug' => 'long-arm-sany-pc-200',
                'description' => 'Excavator dengan lengan panjang (long arm), cocok untuk pekerjaan galian sungai, kanal, dan rawa.',
                'price_per_day' => 2600000,
                'stock' => 2,
                'brand' => 'SANY',
                'model' => 'PC 200 Long Arm',
                'manufacture_year' => 2019,
                'specifications' => [
                    'kapasitas_bucket' => '0.8 m³',
                    'jangkauan_kerja' => 'hingga 15 m',
                    'berat_operasi' => '21 ton',
                    'arm_length' => '8.5 meter',
                    'kedalaman_galian_max' => '11 meter'
                ],
                'category_id' => $excavatorCategory->id,
                'is_active' => true
            ],
            
            // 6. Grader
            [
                'name' => 'Grader',
                'slug' => 'grader',
                'description' => 'Alat perata tanah, sering digunakan untuk perataan jalan dan pekerjaan finishing lahan.',
                'price_per_day' => 3500000,
                'stock' => 1,
                'brand' => 'Generic',
                'model' => 'Motor Grader',
                'manufacture_year' => 2019,
                'specifications' => [
                    'lebar_blade' => '3.6 m',
                    'daya_mesin' => '150-200 HP',
                    'berat_operasi' => '16 ton',
                    'panjang_total' => '8.5 meter',
                    'radius_putar' => '7.3 meter'
                ],
                'category_id' => $bulldozerCategory->id, // Menggunakan kategori bulldozer untuk grader
                'is_active' => true
            ],
            
            // 7. Vibro YHN
            [
                'name' => 'Vibro YHN',
                'slug' => 'vibro-yhn',
                'description' => 'Alat pemadat tanah (vibro roller), digunakan untuk memadatkan jalan, timbunan, dan pondasi.',
                'price_per_day' => 1900000,
                'stock' => 1,
                'brand' => 'YHN',
                'model' => 'Single Drum Vibratory Roller',
                'manufacture_year' => 2017,
                'specifications' => [
                    'berat_operasi' => '10 ton',
                    'lebar_drum' => '2.1 m',
                    'tipe' => 'Single Drum Vibratory Roller',
                    'daya_mesin' => '100 HP',
                    'frekuensi_getaran' => '30 Hz'
                ],
                'category_id' => $loaderCategory->id, // Menggunakan kategori loader untuk vibratory roller
                'is_active' => true
            ],
            
            // 8. Dump Truck Hino FM260JD
            [
                'name' => 'Dump Truck Hino FM260JD',
                'slug' => 'dump-truck-hino-fm260jd',
                'description' => 'Kendaraan pengangkut material (tanah, pasir, batu). Cocok untuk proyek konstruksi dan tambang.',
                'price_per_day' => 1500000,
                'stock' => 20,
                'brand' => 'Hino',
                'model' => 'FM260JD',
                'manufacture_year' => 2018,
                'specifications' => [
                    'kapasitas_muatan' => '20-24 m³',
                    'daya_mesin' => '260 PS',
                    'transmisi' => '6x4 drive',
                    'berat_kosong' => '8.5 ton',
                    'payload_max' => '26 ton'
                ],
                'category_id' => $trontonCategory->id,
                'is_active' => true
            ]
        ];

        foreach ($equipment as $item) {
            // Convert specifications array to JSON
            if (isset($item['specifications']) && is_array($item['specifications'])) {
                $item['specifications'] = json_encode($item['specifications']);
            }
            Equipment::create($item);
        }
        
        echo "Equipment data berhasil diperbarui dengan data dari katalog alat terbaru!\n";
    }
}
