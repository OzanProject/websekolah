<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SchoolProfile::truncate();
        \App\Models\SchoolProfile::create([
            'school_name' => 'SMPN 4 Kadupandak',
            'school_tagline' => 'Sekolah Berkarakter dan Berbudaya Lingkungan',
            'visi' => 'Mewujudkan peserta didik yang beriman, bertaqwa, berkarakter, cerdas, terampil, dan berwawasan lingkungan menuju generasi unggul Indonesia 2045.',
            'misi' => [
                'Menyelenggarakan pendidikan yang berorientasi pada penguatan iman, taqwa, dan akhlak mulia.',
                'Mengembangkan pembelajaran aktif, inovatif, kreatif, dan menyenangkan berbasis Kurikulum Merdeka.',
                'Meningkatkan profesionalisme guru dan tenaga kependidikan secara berkelanjutan.',
                'Mengoptimalkan minat dan bakat peserta didik melalui kegiatan ekstrakurikuler.',
                'Membangun budaya sekolah yang ramah, peduli lingkungan, dan berbudaya literasi.'
            ],
            'stat_student' => 487,
            'stat_teacher' => 38,
            'stat_class' => 18,
            'stat_achievement' => 52,
            'kepsek_name' => 'Dr. Budi Santoso, M.Pd.',
            'sambutan_content' => '<p>Selamat datang di website resmi SMPN 4 Kadupandak. Kami berkomitmen untuk terus memberikan pendidikan terbaik...</p>',
            'contact_address' => 'Jl. Raya Kadupandak No. 123, Cianjur, Jawa Barat',
            'contact_phone' => '081234567890',
            'contact_email' => 'info@smpn4kadupandak.sch.id',
            'contact_hours' => 'Senin - Jumat: 07:00 - 15:00',
            'hero_slides' => [
                ['image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1', 'title' => 'Selamat Datang di SMPN 4 Kadupandak', 'subtitle' => 'Membentuk Generasi Unggul dan Berkarakter'],
                ['image' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754', 'title' => 'Fasilitas Modern', 'subtitle' => 'Mendukung Pembelajaran Abad 21'],
            ],
            'hero_btn1_text' => 'Daftar PPDB',
            'hero_btn1_url' => '/ppdb',
            'hero_btn2_text' => 'Profil Sekolah',
            'hero_btn2_url' => '/page/profil',
            'ppdb_active' => true,
            'ppdb_title' => 'Penerimaan Peserta Didik Baru (PPDB) 2026/2027',
            'ppdb_year' => '2026/2027',
            'ppdb_description' => 'Bergabunglah bersama kami untuk masa depan yang lebih cerah.',
        ]);
    }
}
