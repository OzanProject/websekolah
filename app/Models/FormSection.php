<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSection extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'order_weight', 'is_active'];

    public function fields()
    {
        return $this->hasMany(FormField::class)->orderBy('order_weight', 'asc');
    }
}
