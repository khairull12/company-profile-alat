<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Data berdasarkan Aset Perusahaan dari dokumen
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
        $excavatorCategory = Category::where('slug', 'excavator')->first();
        $trontonCategory = Category::where('slug', 'tronton')->first();
        $bulldozerCategory = Category::where('slug', 'bulldozer')->first();
        $craneCategory = Category::where('slug', 'crane')->first();
        $loaderCategory = Category::where('slug', 'loader')->first();

        // Data equipment berdasarkan aset perusahaan
        $equipment = [
            // PC 200 Series (Excavator)
            [
                'name' => 'SUMITOMO PC 200',
                'slug' => 'sumitomo-pc-200',
                'description' => 'Excavator Sumitomo PC 200 tahun 2017 dengan performa andal untuk berbagai pekerjaan konstruksi dan penggalian.',
                'price_per_day' => 2200000,
                'stock' => 1,
                'brand' => 'Sumitomo',
                'model' => 'PC 200',
                'manufacture_year' => 2017,
                'specifications' => [
                    'engine_power' => '148 HP',
                    'operating_weight' => '20 ton',
                    'bucket_capacity' => '1.0 m³',
                    'max_digging_depth' => '6.5 m',
                    'fuel_capacity' => '400 L'
                ],
                'category_id' => $excavatorCategory->id,
                'is_active' => true
            ],
            [
                'name' => 'SANY PC 200',
                'slug' => 'sany-pc-200',
                'description' => 'Excavator SANY PC 200 dengan teknologi terkini. Tersedia 4 unit untuk kebutuhan proyek besar.',
                'price_per_day' => 2100000,
                'stock' => 4,
                'brand' => 'SANY',
                'model' => 'PC 200',
                'manufacture_year' => 2020,
                'specifications' => [
                    'engine_power' => '140 HP',
                    'operating_weight' => '19.5 ton',
                    'bucket_capacity' => '0.9 m³',
                    'max_digging_depth' => '6.2 m',
                    'fuel_capacity' => '380 L'
                ],
                'category_id' => $excavatorCategory->id,
                'is_active' => true
            ],
            [
                'name' => 'YUNDAI PC 215',
                'slug' => 'yundai-pc-215',
                'description' => 'Excavator Hyundai PC 215 tahun 2021 dengan kapasitas lebih besar. Tersedia 6 unit untuk proyek skala menengah hingga besar.',
                'price_per_day' => 2400000,
                'stock' => 6,
                'brand' => 'Hyundai',
                'model' => 'PC 215',
                'manufacture_year' => 2021,
                'specifications' => [
                    'engine_power' => '158 HP',
                    'operating_weight' => '21.5 ton',
                    'bucket_capacity' => '1.2 m³',
                    'max_digging_depth' => '6.8 m',
                    'fuel_capacity' => '420 L'
                ],
                'category_id' => $excavatorCategory->id,
                'is_active' => true
            ],
            [
                'name' => 'LIUGONG PC 200',
                'slug' => 'liugong-pc-200',
                'description' => 'Excavator LiuGong PC 200 tahun 2024 terbaru dengan teknologi mutakhir. Tersedia 5 unit kondisi prima.',
                'price_per_day' => 2300000,
                'stock' => 5,
                'brand' => 'LiuGong',
                'model' => 'PC 200',
                'manufacture_year' => 2024,
                'specifications' => [
                    'engine_power' => '145 HP',
                    'operating_weight' => '19.8 ton',
                    'bucket_capacity' => '1.0 m³',
                    'max_digging_depth' => '6.4 m',
                    'fuel_capacity' => '390 L'
                ],
                'category_id' => $excavatorCategory->id,
                'is_active' => true
            ],
            [
                'name' => 'LONG ARM SANY PC 200',
                'slug' => 'long-arm-sany-pc-200',
                'description' => 'Excavator SANY PC 200 dengan long arm tahun 2019 untuk pekerjaan jangkauan jauh. Tersedia 2 unit.',
                'price_per_day' => 2600000,
                'stock' => 2,
                'brand' => 'SANY',
                'model' => 'PC 200 Long Arm',
                'manufacture_year' => 2019,
                'specifications' => [
                    'engine_power' => '140 HP',
                    'operating_weight' => '20.5 ton',
                    'bucket_capacity' => '0.8 m³',
                    'max_digging_depth' => '8.5 m',
                    'arm_length' => '4.5 m',
                    'fuel_capacity' => '380 L'
                ],
                'category_id' => $excavatorCategory->id,
                'is_active' => true
            ],
            
            // Greder
            [
                'name' => 'GREDER Motor Grader',
                'slug' => 'greder-motor-grader',
                'description' => 'Motor Grader tahun 2019 untuk pekerjaan perataan jalan dan tanah. Blade adjustable dengan kontrol hidrolik.',
                'price_per_day' => 3200000,
                'stock' => 1,
                'brand' => 'Generic',
                'model' => 'Motor Grader',
                'manufacture_year' => 2019,
                'specifications' => [
                    'engine_power' => '190 HP',
                    'operating_weight' => '15.5 ton',
                    'blade_width' => '3.7 m',
                    'blade_height' => '0.6 m',
                    'fuel_capacity' => '300 L'
                ],
                'category_id' => $bulldozerCategory->id, // Menggunakan kategori bulldozer untuk grader
                'is_active' => true
            ],
            
            // Vibro Compactor
            [
                'name' => 'VIBRO YHN Compactor',
                'slug' => 'vibro-yhn-compactor',
                'description' => 'Vibro Compactor YHN tahun 2017 untuk pemadatan tanah dan aspal. Sistem getaran ganda untuk hasil optimal.',
                'price_per_day' => 1800000,
                'stock' => 1,
                'brand' => 'YHN',
                'model' => 'Vibro Compactor',
                'manufacture_year' => 2017,
                'specifications' => [
                    'engine_power' => '75 HP',
                    'operating_weight' => '8.5 ton',
                    'drum_width' => '1.68 m',
                    'compaction_force' => '140 kN',
                    'fuel_capacity' => '120 L'
                ],
                'category_id' => $loaderCategory->id, // Menggunakan kategori loader untuk compactor
                'is_active' => true
            ],
            
            // Dump Truck
            [
                'name' => 'DUMP TRUCK HINO FM260JD',
                'slug' => 'dump-truck-hino-fm260jd-putih',
                'description' => 'Dump Truck Hino FM260JD warna putih tahun 2018. Tersedia 20 unit untuk kebutuhan pengangkutan material dalam jumlah besar.',
                'price_per_day' => 1500000,
                'stock' => 20,
                'brand' => 'Hino',
                'model' => 'FM260JD',
                'manufacture_year' => 2018,
                'specifications' => [
                    'engine_power' => '260 HP',
                    'payload' => '15 ton',
                    'dump_body_capacity' => '12 m³',
                    'gross_weight' => '26 ton',
                    'wheelbase' => '4.2 m',
                    'fuel_capacity' => '200 L'
                ],
                'category_id' => $trontonCategory->id,
                'is_active' => true
            ]
        ];

        foreach ($equipment as $item) {
            // Convert specifications array to JSON if it's an array
            if (isset($item['specifications']) && is_array($item['specifications'])) {
                $item['specifications'] = json_encode($item['specifications']);
            }
            Equipment::create($item);
        }
        
        echo "Equipment data berhasil diperbarui dengan data dari aset perusahaan!\n";
    }
}
