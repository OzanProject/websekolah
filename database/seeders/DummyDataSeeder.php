<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\Agenda;
use App\Models\Facility;
use App\Models\Gallery;
use App\Models\Testimonial;
use App\Models\Video;
use App\Models\Page;
use Illuminate\Support\Facades\Schema;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // 1. Program Unggulan
        Program::truncate();
        $programs = [
            ['title' => 'Tahfidz Qur\'an', 'description' => 'Program menghafal Al-Qur\'an bagi siswa dengan target minimal 1 Juz per tahun.', 'icon' => 'book-open'],
            ['title' => 'Bilingual Class', 'description' => 'Kelas khusus dengan pengantar bahasa Inggris dan Arab untuk mata pelajaran tertentu.', 'icon' => 'languages'],
            ['title' => 'Pramuka Garuda', 'description' => 'Pembinaan karakter dan kemandirian siswa melalui program Pramuka tingkat Garuda.', 'icon' => 'tent'],
            ['title' => 'Klinik Sains', 'description' => 'Pendalaman materi MIPA bagi siswa berbakat untuk dipersiapkan menuju olimpiade.', 'icon' => 'flask-conical'],
        ];
        foreach ($programs as $p) Program::create($p);

        // 2. Agenda
        Agenda::truncate();
        $agendas = [
            [
                'title' => 'Rapat Orang Tua Murid Kelas 7',
                'date' => now()->addDays(5)->format('Y-m-d'),
                'time' => '08:00 - 11:00',
                'location' => 'Aula Utama SMPN 4',
            ],
            [
                'title' => 'Study Tour Ke Museum Geologi Bandung',
                'date' => now()->addDays(14)->format('Y-m-d'),
                'time' => '06:00 - 16:00',
                'location' => 'Museum Geologi, Bandung',
            ],
            [
                'title' => 'Ujian Akhir Semester Ganjil',
                'date' => now()->addDays(30)->format('Y-m-d'),
                'time' => '07:30 - 12:00',
                'location' => 'Ruang Kelas Masing-masing',
            ]
        ];
        foreach ($agendas as $a) Agenda::create($a);

        // 3. Fasilitas
        Facility::truncate();
        $facilities = [
            ['title' => 'Perpustakaan Digital', 'description' => 'Ruang perpustakaan yang dilengkapi dengan komputer dan koleksi buku e-book.', 'image_path' => 'https://images.unsplash.com/photo-1541963463532-d68292c34b19'],
            ['title' => 'Laboratorium IPA', 'description' => 'Laboratorium Fisika dan Biologi dengan peralatan praktikum modern.', 'image_path' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158'],
            ['title' => 'Masjid Raya Sekolah', 'description' => 'Masjid luas yang mampu menampung seluruh siswa untuk shalat berjamaah.', 'image_path' => 'https://images.unsplash.com/photo-1564683214965-3619addd900d'],
            ['title' => 'Lapangan Olahraga', 'description' => 'Lapangan futsal, basket, dan voli yang terintegrasi di tengah area sekolah.', 'image_path' => 'https://images.unsplash.com/photo-1628891890467-b79f2c8ba9dc'],
        ];
        foreach ($facilities as $f) Facility::create($f);

        // 4. Galeri
        Gallery::truncate();
        $galleries = [
            ['title' => 'Porseni 2025', 'image_path' => 'https://images.unsplash.com/photo-1561489422-45de3d015e3e'],
            ['title' => 'Upacara HUT RI', 'image_path' => 'https://images.unsplash.com/photo-1586398711413-4e3864fb8ec0'],
            ['title' => 'Praktikum Kimia', 'image_path' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d'],
            ['title' => 'Perkemahan Pramuka', 'image_path' => 'https://images.unsplash.com/photo-1504280327332-9472ff3cbbe8'],
            ['title' => 'Kelulusan 2025', 'image_path' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1'],
            ['title' => 'Pentas Seni Angklung', 'image_path' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4'],
        ];
        foreach ($galleries as $g) Gallery::create($g);

        // 5. Testimoni
        Testimonial::truncate();
        $testimonials = [
            ['name' => 'Budi Santoso', 'role' => 'Alumni Angkatan 2020', 'quote' => 'Sekolah ini sangat membekas di hati saya. Guru-gurunya sangat sabar dan fasilitasnya memadai untuk menunjang kreativitas siswa.', 'avatar_path' => 'https://randomuser.me/api/portraits/men/32.jpg'],
            ['name' => 'Siti Aisyah', 'role' => 'Orang Tua Siswa', 'quote' => 'Saya sangat bersyukur menyekolahkan anak saya di sini. Program tahfidznya luar biasa dan kedisiplinannya sangat terjaga.', 'avatar_path' => 'https://randomuser.me/api/portraits/women/44.jpg'],
            ['name' => 'Ridwan Kamil', 'role' => 'Tokoh Masyarakat', 'quote' => 'Lulusan sekolah ini terkenal memiliki akhlak yang baik dan mampu bersaing di SMA-SMA favorit di provinsi.', 'avatar_path' => 'https://randomuser.me/api/portraits/men/85.jpg'],
        ];
        foreach ($testimonials as $t) Testimonial::create($t);

        // 6. Video
        Video::truncate();
        Video::create([
            'title' => 'Video Profil Resmi Sekolah',
            'description' => 'Mengenal lebih dekat lingkungan, fasilitas, dan kegiatan unggulan di sekolah kami.',
            'url' => 'https://www.youtube.com/watch?v=LXb3EKWsInQ',
            'is_active' => true,
        ]);

        // 7. Page
        Page::truncate();
        $pages = [
            ['title' => 'Sejarah Sekolah', 'slug' => 'sejarah', 'content' => '<p>SMPN 4 Kadupandak didirikan pada tahun 1995 dengan tujuan memberikan pendidikan berkualitas tinggi bagi masyarakat sekitar.</p>', 'is_active' => true],
            ['title' => 'Struktur Organisasi', 'slug' => 'struktur-organisasi', 'content' => '<p>Berikut adalah struktur organisasi sekolah kami yang dipimpin oleh Bapak Kepala Sekolah...</p>', 'is_active' => true],
        ];
        foreach ($pages as $p) Page::create($p);

        Schema::enableForeignKeyConstraints();
    }
}
