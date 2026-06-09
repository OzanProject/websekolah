<?php

namespace App\Imports;

use App\Models\Testimonial;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TestimonialImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['name']) || empty($row['name'])) {
            return null;
        }

        return new Testimonial([
            'name'  => $row['name'] ?? $row['nama'] ?? 'Tanpa Nama',
            'role'  => $row['role'] ?? $row['peran'] ?? 'Alumni',
            'quote' => $row['quote'] ?? $row['kutipan'] ?? 'Sekolah yang luar biasa!',
            'avatar_path' => null, // Akan diisi URL acak oleh frontend atau null
        ]);
    }
}
