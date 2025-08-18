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
                'value' => 'PT. Dhiva Sarana Transport (DST) adalah perusahaan yang didirikan pada tahun 2022 bergerak di bidang jasa penyewaan alat transportasi dan alat berat, pembukaan lahan dan kontraktor umum. Kami mengembangkan usaha secara profesional dengan dedikasi tinggi dan tenaga yang handal serta berpengalaman di bidangnya masing-masing.',
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
                'key' => 'company_background',
                'value' => 'Maha Suci Tuhan dengan segala limpahan karunia dan rahmat Nya, yang memenuhi semesta ini dan terus mengalir tanpa henti kepada umat nya sejalan dengan perkembangan dunia usaha yang seiring dengan perkembangan ilmu pengetahuan dan teknologi, maka kita dituntun terus berkembang dalam menerapkan ilmu pengetahuan pada dunia usaha kita agar mampu berinovasi dan berkreatifitas.',
                'type' => 'editor',
                'group' => 'about'
            ],
            [
                'key' => 'company_founding',
                'value' => 'PT. Dhiva Sarana Transport (DST) adalah sebuah perusahaan yang didirikan pada tahun 2022 yang bergerak di bidang jasa penyewaan alat transportasi dan alat berat, Pembukaan lahan dan kontraktor umum. Tujuan Perusahaan ini di dirikan adalah untuk mengembangkan usaha secara profesional yang berdedikasi tinggi dengan tenaga yang handal dan berpengalaman di bidangnya masing – masing.',
                'type' => 'editor',
                'group' => 'about'
            ],
            [
                'key' => 'about_us_content',
                'value' => '<p><strong>Maha Suci Tuhan dengan segala limpahan karunia dan rahmat Nya</strong>, yang memenuhi semesta ini dan terus mengalir tanpa henti kepada umat nya sejalan dengan perkembangan dunia usaha yang seiring dengan perkembangan ilmu pengetahuan dan teknologi, maka kita dituntun terus berkembang dalam menerapkan ilmu pengetahuan pada dunia usaha kita agar mampu berinovasi dan berkreatifitas.</p><br><p><strong>PT. Dhiva Sarana Transport (DST)</strong> adalah sebuah perusahaan yang didirikan pada tahun <strong>2022</strong> yang bergerak di bidang <strong>jasa penyewaan alat transportasi dan alat berat, Pembukaan lahan dan kontraktor umum</strong>. Tujuan Perusahaan ini di dirikan adalah untuk mengembangkan usaha secara profesional yang berdedikasi tinggi dengan tenaga yang handal dan berpengalaman di bidangnya masing – masing.</p><br><p>Dengan pengalaman dan komitmen yang kuat, kami terus berupaya memberikan pelayanan terbaik kepada setiap klien. Kepercayaan dan kepuasan pelanggan adalah prioritas utama dalam setiap layanan yang kami berikan, mulai dari penyewaan alat berat, pembukaan lahan, hingga jasa kontraktor umum.</p>',
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
