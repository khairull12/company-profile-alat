<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Company Profile
            [
                'key' => 'company_name',
                'value' => 'PT. Dhiva Sarana Transport Konstruksi',
                'type' => 'text',
                'group' => 'company'
            ],
            [
                'key' => 'company_description',
                'value' => 'Perusahaan penyedia layanan penyewaan alat berat terpercaya dengan pengalaman lebih dari 10 tahun. Kami menyediakan berbagai macam alat berat berkualitas untuk kebutuhan konstruksi Anda.',
                'type' => 'textarea',
                'group' => 'company'
            ],
            [
                'key' => 'company_address',
                'value' => 'Jl. Industri Raya No. 123, Jakarta Timur, DKI Jakarta 13750',
                'type' => 'textarea',
                'group' => 'company'
            ],
            [
                'key' => 'company_phone',
                'value' => '+62 21 1234 5678',
                'type' => 'text',
                'group' => 'company'
            ],
            [
                'key' => 'company_email',
                'value' => 'info@alatberatkontruksi.com',
                'type' => 'text',
                'group' => 'company'
            ],
            [
                'key' => 'company_website',
                'value' => 'www.alatberatkontruksi.com',
                'type' => 'text',
                'group' => 'company'
            ],
            
            // About Us
            [
                'key' => 'about_us_title',
                'value' => 'Tentang PT. Dhiva Sarana Transport Konstruksi',
                'type' => 'text',
                'group' => 'about'
            ],
            [
                'key' => 'about_us_content',
                'value' => 'PT. Dhiva Sarana Transport Konstruksi adalah perusahaan penyedia layanan penyewaan alat berat yang telah berpengalaman lebih dari 10 tahun dalam industri konstruksi. Kami berkomitmen untuk memberikan pelayanan terbaik dengan menyediakan alat berat berkualitas tinggi dan terawat untuk mendukung keberhasilan proyek konstruksi Anda.<br><br>Dengan armada yang lengkap dan tim teknisi berpengalaman, kami siap melayani berbagai kebutuhan alat berat untuk proyek konstruksi, infrastruktur, dan pertambangan. Kepercayaan klien adalah prioritas utama kami.',
                'type' => 'editor',
                'group' => 'about'
            ],
            
            // Vision Mission
            [
                'key' => 'vision_title',
                'value' => 'Visi Kami',
                'type' => 'text',
                'group' => 'vision_mission'
            ],
            [
                'key' => 'vision_content',
                'value' => 'Menjadi perusahaan penyedia layanan penyewaan alat berat terkemuka di Indonesia yang dipercaya dan memberikan solusi terbaik untuk setiap kebutuhan konstruksi.',
                'type' => 'editor',
                'group' => 'vision_mission'
            ],
            [
                'key' => 'mission_title',
                'value' => 'Misi Kami',
                'type' => 'text',
                'group' => 'vision_mission'
            ],
            [
                'key' => 'mission_content',
                'value' => '<ul><li>Menyediakan alat berat berkualitas tinggi dengan kondisi prima</li><li>Memberikan pelayanan profesional dan responsif kepada setiap klien</li><li>Membantu kesuksesan proyek konstruksi dengan dukungan teknis terbaik</li><li>Mengutamakan keselamatan dan keamanan dalam setiap operasional</li><li>Terus berinovasi untuk meningkatkan kualitas layanan</li></ul>',
                'type' => 'editor',
                'group' => 'vision_mission'
            ],
            
            // Hero Section
            [
                'key' => 'hero_title',
                'value' => 'Solusi Penyewaan Alat Berat Terpercaya',
                'type' => 'text',
                'group' => 'hero'
            ],
            [
                'key' => 'hero_subtitle',
                'value' => 'Kami menyediakan berbagai macam alat berat berkualitas untuk kebutuhan konstruksi Anda',
                'type' => 'text',
                'group' => 'hero'
            ],
            [
                'key' => 'hero_image',
                'value' => '',
                'type' => 'image',
                'group' => 'hero'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
