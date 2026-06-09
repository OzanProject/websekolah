<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormRequirement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_required', 'order_weight'];

    protected $casts = [
        'is_required' => 'boolean',
    ];
}
