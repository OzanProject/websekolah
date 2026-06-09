<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ppdb extends Model
{
    protected $fillable = [
        'nomor',
        'status',
        'pesan_status',
        'form_data',
        'requirements_data'
    ];

    protected $casts = [
        'form_data' => 'array',
        'requirements_data' => 'array',
    ];
}
