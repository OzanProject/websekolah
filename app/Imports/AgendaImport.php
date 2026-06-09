<?php

namespace App\Imports;

use App\Models\Agenda;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AgendaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['title']) || empty($row['title'])) {
            return null;
        }

        return new Agenda([
            'title'    => $row['title'] ?? $row['judul'] ?? 'Tanpa Judul',
            'date'     => $row['date'] ?? $row['tanggal'] ?? now()->format('Y-m-d'),
            'time'     => $row['time'] ?? $row['waktu'] ?? '08:00',
            'location' => $row['location'] ?? $row['lokasi'] ?? 'Sekolah',
        ]);
    }
}
