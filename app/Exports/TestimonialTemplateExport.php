<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TestimonialTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['Budi Santoso', 'Alumni 2025', 'Pendidikan di SMPN 4 sangat membantu karier saya.'],
            ['Ibu Ratna', 'Orang Tua Siswa', 'Fasilitas lengkap dan guru-gurunya ramah.'],
        ];
    }

    public function headings(): array
    {
        return ['Name', 'Role', 'Quote'];
    }
}
