<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NewsTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['Juara Olimpiade Matematika', '<p>Siswa sekolah kita berhasil meraih medali emas di tingkat provinsi.</p>', '2026-06-08'],
            ['Penerimaan Siswa Baru', '<p>Pendaftaran gelombang pertama dibuka mulai hari ini.</p>', '2026-06-10'],
        ];
    }

    public function headings(): array
    {
        return ['Title', 'Content', 'Date'];
    }
}
