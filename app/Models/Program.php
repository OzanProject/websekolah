<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class Program extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'description'];

    protected $fillable = ['title', 'description', 'icon'];
}
