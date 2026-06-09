<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FacilityTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['Perpustakaan Digital', 'Dilengkapi dengan komputer dan akses e-book.'],
            ['Laboratorium Komputer', 'Laboratorium modern dengan 40 unit PC.'],
        ];
    }

    public function headings(): array
    {
        return ['Title', 'Description'];
    }
}
