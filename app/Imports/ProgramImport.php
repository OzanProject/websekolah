<?php

namespace App\Imports;

use App\Models\Program;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProgramImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Abaikan baris kosong
        if (!isset($row['title']) || empty($row['title'])) {
            return null;
        }

        return new Program([
            'title'       => $row['title'] ?? $row['judul'] ?? 'Tanpa Judul',
            'description' => $row['description'] ?? $row['deskripsi'] ?? '-',
            'icon'        => $row['icon'] ?? $row['ikon'] ?? 'fa-star',
        ]);
    }
}
