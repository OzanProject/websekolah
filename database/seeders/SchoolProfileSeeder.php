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
        \App\Models\SchoolProfile::create([
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
        ]);
    }
}
