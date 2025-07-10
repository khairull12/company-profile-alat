<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Excavator',
                'slug' => 'excavator',
                'description' => 'Alat berat untuk menggali, memuat dan memindahkan material',
                'is_active' => true
            ],
            [
                'name' => 'Tronton',
                'slug' => 'tronton',
                'description' => 'Truk berat untuk mengangkut material konstruksi',
                'is_active' => true
            ],
            [
                'name' => 'Bulldozer',
                'slug' => 'bulldozer',
                'description' => 'Alat berat untuk meratakan dan memindahkan tanah',
                'is_active' => true
            ],
            [
                'name' => 'Crane',
                'slug' => 'crane',
                'description' => 'Alat angkat untuk material konstruksi',
                'is_active' => true
            ],
            [
                'name' => 'Loader',
                'slug' => 'loader',
                'description' => 'Alat berat untuk memuat material ke truk',
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
