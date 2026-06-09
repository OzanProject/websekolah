<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SchoolProfile extends Model
{
    use HasTranslations;

    public $translatable = ['visi', 'misi', 'sambutan_content', 'ppdb_title', 'ppdb_description'];

    protected $fillable = [
        'visi',
        'misi',
        'stat_student',
        'stat_teacher',
        'stat_class',
        'stat_achievement',
        'kepsek_name',
        'kepsek_image',
        'sambutan_content',
        'contact_address',
        'contact_phone',
        'contact_email',
        'contact_hours',
        'contact_map',
        'social_facebook',
        'social_instagram',
        'social_youtube',
        'footer_navigations',
        'footer_related_links',
        'header_navigations',
        'school_name',
        'school_tagline',
        'school_logo',
        'school_npsn',
        'school_nss',
        'school_accreditation',
        'tinymce_api_key',
        'hero_slides',
        'ppdb_active',
        'ppdb_title',
        'ppdb_year',
        'ppdb_description',
        'hero_btn1_text',
        'hero_btn1_url',
        'hero_btn2_text',
        'hero_btn2_url',
        'ppdb_slug',
    ];

    protected $casts = [
        'misi' => 'array',
        'footer_navigations' => 'array',
        'footer_related_links' => 'array',
        'header_navigations' => 'array',
        'hero_slides' => 'array',
        'ppdb_active' => 'boolean',
    ];
}
