<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['email']) || empty($row['email'])) {
            return null;
        }

        // Cek apakah email sudah ada agar tidak duplikat
        $existingUser = User::where('email', $row['email'])->first();
        if ($existingUser) {
            return null;
        }

        return new User([
            'name'     => $row['name'] ?? $row['nama'] ?? 'Admin Baru',
            'email'    => $row['email'],
            'password' => Hash::make($row['password'] ?? 'password123'), // Default password jika kosong
        ]);
    }
}
