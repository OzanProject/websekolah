<?php

namespace App\Imports;

use App\Models\Gallery;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GalleryImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['title']) || empty($row['title'])) {
            return null;
        }

        return new Gallery([
            'title'       => $row['title'] ?? $row['nama'] ?? 'Tanpa Nama',
            'image_path'  => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644', // Default image for imported data
        ]);
    }
}
