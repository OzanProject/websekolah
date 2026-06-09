<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProgramTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['Beasiswa Prestasi', 'Program beasiswa penuh bagi siswa berprestasi akademik.', 'fa-award'],
            ['Eskul Robotik', 'Pengembangan kreativitas di bidang teknologi dan robotika.', 'fa-robot'],
        ];
    }

    public function headings(): array
    {
        return ['Title', 'Description', 'Icon'];
    }
}
