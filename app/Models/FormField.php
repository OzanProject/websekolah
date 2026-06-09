<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_section_id', 'label', 'name', 'help_text', 'type', 
        'options', 'is_required', 'is_active', 'is_featured', 'order_weight'
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function section()
    {
        return $this->belongsTo(FormSection::class, 'form_section_id');
    }
}
