<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function profil()
    {
        $profile = \App\Models\SchoolProfile::first();
        return view('pages.profil', compact('profile'));
    }

    public function program()
    {
        $programs = \App\Models\Program::all();
        return view('pages.program', compact('programs'));
    }

    public function galeri()
    {
        $galleryItems = \App\Models\Gallery::all();
        $gallery = $galleryItems->map(function($item) {
            return [
                'src' => filter_var($item->image_path, FILTER_VALIDATE_URL) ? $item->image_path : asset('storage/' . $item->image_path),
                'title' => $item->title
            ];
        })->toArray();
        
        $video = \App\Models\Video::where('is_active', true)->first();

        return view('pages.galeri', compact('gallery', 'video'));
    }

    public function agenda()
    {
        $agendaItems = \App\Models\Agenda::orderBy('date', 'asc')->get();
        $agenda = $agendaItems->map(function($item) {
            $date = \Carbon\Carbon::parse($item->date);
            return [
                'title' => $item->title,
                'date' => $item->date,
                'day' => $date->format('d'),
                'month' => $date->translatedFormat('M'),
                'time' => $item->time,
                'location' => $item->location,
            ];
        })->toArray();

        return view('pages.agenda', compact('agenda'));
    }

    public function fasilitas()
    {
        $facilityItems = \App\Models\Facility::all();
        $facilities = $facilityItems->map(function($item) {
            return [
                'title' => $item->title,
                'desc' => $item->description,
                'icon' => $item->icon ?: 'building-2',
                'image' => filter_var($item->image_path, FILTER_VALIDATE_URL) ? $item->image_path : asset('storage/' . $item->image_path),
            ];
        })->toArray();

        return view('pages.fasilitas', compact('facilities'));
    }

    public function kontak()
    {
        $profile = \App\Models\SchoolProfile::first();
        return view('pages.kontak', compact('profile'));
    }

    public function showCustomPage($slug)
    {
        $page = \App\Models\Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('pages.custom', compact('page'));
    }
}
