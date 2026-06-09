<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GalleryTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['Kegiatan Pramuka 2026'],
            ['Upacara Bendera Hari Senin'],
        ];
    }

    public function headings(): array
    {
        return ['Title'];
    }
}
