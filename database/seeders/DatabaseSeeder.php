<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\News;
use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.com',
            'password' => bcrypt('password'),
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'admin@smpn4kadupandak.sch.id'],
            [
                'name' => 'Admin Humas',
                'password' => bcrypt('password'),
            ]
        );

        $catPrestasi = Category::firstOrCreate(['slug' => 'prestasi'], ['name' => 'Prestasi']);
        $catPengumuman = Category::firstOrCreate(['slug' => 'pengumuman'], ['name' => 'Pengumuman']);
        $catKegiatan = Category::firstOrCreate(['slug' => 'kegiatan'], ['name' => 'Kegiatan']);

        $news = [
            [
                'title' => 'Siswa SMPN 4 Kadupandak Raih Juara 1 Olimpiade Sains Tingkat Kabupaten',
                'slug' => 'juara-1-olimpiade-sains-kabupaten-2025',
                'content' => "Kabar membanggakan kembali datang dari SMPN 4 Kadupandak. Tim Sains sekolah berhasil meraih Juara 1 pada Olimpiade Sains Tingkat Kabupaten Cianjur yang diselenggarakan oleh Dinas Pendidikan Kabupaten Cianjur pada tanggal 10–12 Desember 2025 di GOR Cianjur.\n\nKompetisi ini diikuti oleh 48 sekolah dari seluruh wilayah Kabupaten Cianjur dengan total peserta lebih dari 300 siswa. Tim kami yang terdiri dari Ahmad Fadli (Kelas IX-A), Nisa Aulia (Kelas IX-B), dan Reza Pratama (Kelas VIII-A) tampil sangat percaya diri pada babak final yang menguji penguasaan materi Fisika, Biologi, dan Kimia.",
                'image' => 'https://images.pexels.com/photos/32279016/pexels-photo-32279016.jpeg',
                'date' => '2025-12-12',
                'category_id' => $catPrestasi->id,
                'author_id' => $admin->id
            ],
            [
                'title' => 'Pelaksanaan Asesmen Nasional Berbasis Komputer (ANBK) Berjalan Lancar',
                'slug' => 'anbk-2025-berjalan-lancar',
                'content' => "Asesmen Nasional Berbasis Komputer (ANBK) Tahun 2025 di SMPN 4 Kadupandak telah dilaksanakan pada tanggal 2 – 5 Desember 2025. Kegiatan ini diikuti oleh 45 siswa kelas VIII yang dipilih secara acak oleh sistem Pusat Asesmen Pendidikan Kemendikbudristek.\n\nANBK terdiri dari tiga komponen utama: Asesmen Kompetensi Minimum (AKM), Survei Karakter, dan Survei Lingkungan Belajar. Pelaksanaan dilakukan dalam dua sesi per hari di Lab Komputer sekolah yang telah dilengkapi dengan 40 unit PC dan koneksi internet stabil.",
                'image' => 'https://images.unsplash.com/photo-1660128359946-5d09e282a8a7',
                'date' => '2025-12-05',
                'category_id' => $catKegiatan->id,
                'author_id' => $admin->id
            ],
            [
                'title' => 'Peringatan Hari Guru Nasional 2025 di SMPN 4 Kadupandak',
                'slug' => 'peringatan-hari-guru-nasional-2025',
                'content' => "Hari Guru Nasional 2025 diperingati dengan penuh khidmat dan kemeriahan di SMPN 4 Kadupandak pada Selasa, 25 November 2025. Tema nasional tahun ini adalah \"Guru Hebat, Indonesia Kuat\" yang menjadi inspirasi seluruh rangkaian acara.\n\nAcara dimulai dengan upacara bendera pukul 07.00 WIB yang dipimpin oleh perwakilan siswa kelas IX. Setelah upacara, dilanjutkan dengan persembahan dari OSIS berupa pemberian bunga dan kartu ucapan kepada seluruh bapak/ibu guru.",
                'image' => 'https://images.unsplash.com/photo-1514369118554-e20d93546b30',
                'date' => '2025-11-25',
                'category_id' => $catKegiatan->id,
                'author_id' => $admin->id
            ],
            [
                'title' => 'Sosialisasi PPDB Tahun Ajaran 2026/2027 Resmi Dibuka',
                'slug' => 'sosialisasi-ppdb-2026-2027',
                'content' => "SMPN 4 Kadupandak resmi membuka pendaftaran peserta didik baru (PPDB) untuk tahun ajaran 2026/2027. Sosialisasi awal dilakukan pada Kamis, 15 Januari 2026 di Ruang Multimedia sekolah dengan dihadiri oleh perwakilan SD/MI di sekitar wilayah Kadupandak.\n\nPendaftaran dibuka melalui empat jalur: Jalur Zonasi (50%), Jalur Afirmasi (15%), Jalur Perpindahan Tugas Orang Tua (5%), dan Jalur Prestasi (30%). Pendaftaran dilakukan secara online melalui website resmi sekolah di menu PPDB.",
                'image' => 'https://images.pexels.com/photos/8617715/pexels-photo-8617715.jpeg',
                'date' => '2026-01-15',
                'category_id' => $catPengumuman->id,
                'author_id' => $admin->id
            ]
        ];

        // Kosongkan tabel news agar tidak duplicate
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        News::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        foreach ($news as $item) {
            News::create($item);
        }

        $this->call(SchoolProfileSeeder::class);
        $this->call(DummyDataSeeder::class);
    }
}
