<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AgendaTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['Rapat Wali Murid', '2026-07-15', '08:00 - 10:00', 'Aula Sekolah'],
            ['Ujian Tengah Semester', '2026-09-20', '07:30 - Selesai', 'Ruang Kelas'],
        ];
    }

    public function headings(): array
    {
        return ['Title', 'Date', 'Time', 'Location'];
    }
}
