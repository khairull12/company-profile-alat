<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $excavatorCategory = Category::where('slug', 'excavator')->first();
        $trontonCategory = Category::where('slug', 'tronton')->first();
        $bulldozerCategory = Category::where('slug', 'bulldozer')->first();
        $craneCategory = Category::where('slug', 'crane')->first();
        $loaderCategory = Category::where('slug', 'loader')->first();

        $equipment = [
            // Excavator
            [
                'name' => 'Excavator CAT 320D',
                'slug' => 'excavator-cat-320d',
                'description' => 'Excavator Caterpillar 320D dengan performa tinggi dan efisiensi bahan bakar yang baik. Cocok untuk proyek konstruksi besar.',
                'price_per_day' => 2500000,
                'stock' => 3,
                'brand' => 'Caterpillar',
                'model' => '320D',
                'manufacture_year' => 2020,
                'specifications' => [
                    'engine_power' => '122 HP',
                    'operating_weight' => '20.5 ton',
                    'bucket_capacity' => '1.2 m³',
                    'max_digging_depth' => '6.5 m'
                ],
                'category_id' => $excavatorCategory->id,
                'is_active' => true
            ],
            [
                'name' => 'Excavator Komatsu PC200',
                'slug' => 'excavator-komatsu-pc200',
                'description' => 'Excavator Komatsu PC200 dengan teknologi canggih dan daya tahan yang luar biasa.',
                'price_per_day' => 2300000,
                'stock' => 2,
                'brand' => 'Komatsu',
                'model' => 'PC200',
                'manufacture_year' => 2019,
                'specifications' => [
                    'engine_power' => '148 HP',
                    'operating_weight' => '19.9 ton',
                    'bucket_capacity' => '1.0 m³',
                    'max_digging_depth' => '6.4 m'
                ],
                'category_id' => $excavatorCategory->id,
                'is_active' => true
            ],
            // Tronton
            [
                'name' => 'Tronton Hino FM 260',
                'slug' => 'tronton-hino-fm-260',
                'description' => 'Tronton Hino FM 260 dengan kapasitas angkut besar dan performa mesin yang handal.',
                'price_per_day' => 1800000,
                'stock' => 5,
                'brand' => 'Hino',
                'model' => 'FM 260',
                'manufacture_year' => 2021,
                'specifications' => [
                    'engine_power' => '260 HP',
                    'payload' => '15 ton',
                    'gross_weight' => '26 ton',
                    'wheelbase' => '5.2 m'
                ],
                'category_id' => $trontonCategory->id,
                'is_active' => true
            ],
            [
                'name' => 'Tronton Mitsubishi Fuso FN 527',
                'slug' => 'tronton-mitsubishi-fuso-fn-527',
                'description' => 'Tronton Mitsubishi Fuso dengan teknologi modern dan efisiensi bahan bakar yang optimal.',
                'price_per_day' => 1900000,
                'stock' => 3,
                'brand' => 'Mitsubishi Fuso',
                'model' => 'FN 527',
                'manufacture_year' => 2020,
                'specifications' => [
                    'engine_power' => '270 HP',
                    'payload' => '16 ton',
                    'gross_weight' => '27 ton',
                    'wheelbase' => '5.5 m'
                ],
                'category_id' => $trontonCategory->id,
                'is_active' => true
            ],
            // Bulldozer
            [
                'name' => 'Bulldozer CAT D6T',
                'slug' => 'bulldozer-cat-d6t',
                'description' => 'Bulldozer Caterpillar D6T dengan blade yang kuat untuk pekerjaan perataan tanah.',
                'price_per_day' => 3000000,
                'stock' => 2,
                'brand' => 'Caterpillar',
                'model' => 'D6T',
                'manufacture_year' => 2019,
                'specifications' => [
                    'engine_power' => '215 HP',
                    'operating_weight' => '20.2 ton',
                    'blade_capacity' => '3.4 m³',
                    'ground_pressure' => '0.64 kg/cm²'
                ],
                'category_id' => $bulldozerCategory->id,
                'is_active' => true
            ],
            // Crane
            [
                'name' => 'Mobile Crane XCMG QY25K5',
                'slug' => 'mobile-crane-xcmg-qy25k5',
                'description' => 'Mobile Crane XCMG dengan kapasitas angkat 25 ton dan boom yang dapat diperpanjang.',
                'price_per_day' => 3500000,
                'stock' => 1,
                'brand' => 'XCMG',
                'model' => 'QY25K5',
                'manufacture_year' => 2020,
                'specifications' => [
                    'max_lifting_capacity' => '25 ton',
                    'boom_length' => '31.5 m',
                    'max_working_radius' => '26 m',
                    'engine_power' => '213 HP'
                ],
                'category_id' => $craneCategory->id,
                'is_active' => true
            ],
            // Loader
            [
                'name' => 'Wheel Loader CAT 950M',
                'slug' => 'wheel-loader-cat-950m',
                'description' => 'Wheel Loader Caterpillar 950M dengan bucket besar dan sistem hidrolik yang responsif.',
                'price_per_day' => 2200000,
                'stock' => 2,
                'brand' => 'Caterpillar',
                'model' => '950M',
                'manufacture_year' => 2021,
                'specifications' => [
                    'engine_power' => '174 HP',
                    'operating_weight' => '16.9 ton',
                    'bucket_capacity' => '2.3 m³',
                    'max_dump_height' => '2.8 m'
                ],
                'category_id' => $loaderCategory->id,
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
    }
}
