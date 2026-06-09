<?php

namespace App\Imports;

use App\Models\News;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NewsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['title']) || empty($row['title'])) {
            return null;
        }

        return new News([
            'title'     => $row['title'] ?? $row['judul'] ?? 'Tanpa Judul',
            'slug'      => Str::slug($row['title'] ?? $row['judul'] ?? 'Tanpa Judul') . '-' . time() . rand(100, 999),
            'content'   => $row['content'] ?? $row['konten'] ?? '-',
            'date'      => $row['date'] ?? $row['tanggal'] ?? now()->format('Y-m-d'),
            'author_id' => auth()->id(),
        ]);
    }
}
