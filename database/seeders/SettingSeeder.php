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
                'value' => 'Jl. Apel, Gg Pisang Berangan, No.46',
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
                'value' => 'Menjadi perusahaan jasa terkemuka dan di akui serta yang mampu bersaing secara sehat, dalam pengelolaan dan pelaksanaan sesuai bidang usaha untuk ikut berperan dalam pembangunan yang baik dan berkualitas di masa depan.',
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
                'value' => '<ul><li>Meningkatkan Pelayanan, Menjaga dan menjamin kualitas dalam usaha yang dijalani</li><li>Mengutamakan kerja sama team guna mewujudkan hasil kerja sama yang baik</li><li>Memberikan lingkungan kerja yang aman dan nyaman, meningkatkan kesejahteraan dan memberikan kesempatan berkembang pada karyawan</li><li>Bertanggung jawab atas tugas dan kewajiban dalam menjalankan dan mengerjakan setiap pekerjaan proyek</li><li>Bertanggung jawab terhadap aspek lingkungan yang di timbulkan dari hasil pekerjaan dengan tetap menjaga serta melestarikan lingkungan hidup yang lebih baik</li><li>Selalu berkomitmen dalam mengupayakan penyelesaian pekerjaan dengan tepat waktu tanpa mengurangi kualitas pekerjaan maupun pelayanan</li></ul>',
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
