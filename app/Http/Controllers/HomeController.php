<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        // Data Berita (Dari Database)
        $latestNews = News::with(['category', 'author'])->orderBy('date', 'desc')->take(3)->get();

        // Data Program Unggulan (Dari Database)
        $programs = \App\Models\Program::all();

        // Data Agenda (Dari Database)
        $agendaItems = \App\Models\Agenda::orderBy('date', 'asc')->take(4)->get();
        // Transform the date for the view
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

        // Data Galeri (Dari Database)
        $galleryItems = \App\Models\Gallery::take(8)->get();
        $gallery = $galleryItems->map(function($item) {
            return [
                'src' => filter_var($item->image_path, FILTER_VALIDATE_URL) ? $item->image_path : asset('storage/' . $item->image_path),
                'title' => $item->title
            ];
        })->toArray();

        // Data Fasilitas (Dari Database)
        $facilityItems = \App\Models\Facility::take(6)->get();
        $facilities = $facilityItems->map(function($item) {
            return [
                'title' => $item->title,
                'desc' => $item->description,
                'icon' => $item->icon ?: 'building-2', // Use db icon or default
                'image' => filter_var($item->image_path, FILTER_VALIDATE_URL) ? $item->image_path : asset('storage/' . $item->image_path),
            ];
        })->toArray();

        // Data Testimoni (Dari Database)
        $testimonialItems = \App\Models\Testimonial::take(6)->get();
        $testimonials = $testimonialItems->map(function($item) {
            return [
                'quote' => $item->quote,
                'name' => $item->name,
                'role' => $item->role,
                'avatar' => $item->avatar_path ? (filter_var($item->avatar_path, FILTER_VALIDATE_URL) ? $item->avatar_path : asset('storage/' . $item->avatar_path)) : 'https://ui-avatars.com/api/?name='.urlencode($item->name).'&background=random',
            ];
        })->toArray();

        $video = \App\Models\Video::where('is_active', true)->first();
        $profile = \App\Models\SchoolProfile::first();

        return view('pages.home', compact('latestNews', 'programs', 'agenda', 'gallery', 'facilities', 'testimonials', 'video', 'profile'));
    }
}
