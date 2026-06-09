<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class Testimonial extends Model
{
    use HasTranslations;

    public $translatable = ['quote'];

    protected $fillable = ['name', 'role', 'quote', 'avatar_path'];
}
