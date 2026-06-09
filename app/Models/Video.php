<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\Translatable\HasTranslations;

class Video extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title', 'description'];

    protected $fillable = [
        'title',
        'description',
        'url',
        'is_active',
    ];

    public function youtubeId(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function () {
                if (!$this->url) return null;
                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $this->url, $match)) {
                    return $match[1];
                }
                return null;
            }
        );
    }

    public function thumbnailUrl(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function () {
                $id = $this->youtube_id;
                return $id 
                    ? "https://img.youtube.com/vi/{$id}/hqdefault.jpg" 
                    : "https://images.pexels.com/photos/18145430/pexels-photo-18145430.jpeg";
            }
        );
    }
}
