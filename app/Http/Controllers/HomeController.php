<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        $latestNews = News::with(['category', 'author'])->orderBy('date', 'desc')->take(3)->get();
        $programs = \App\Models\Program::all();
        $video = \App\Models\Video::where('is_active', true)->first();
        $profile = \App\Models\SchoolProfile::first();

        // Tracker Pengunjung
        if (!\Illuminate\Support\Facades\Session::has('visited_home')) {
            if ($profile) {
                $profile->increment('visitor_count');
            }
            \Illuminate\Support\Facades\Session::put('visited_home', true);
        }

        $agenda = $this->getAgenda();
        $gallery = $this->getGallery();
        $facilities = $this->getFacilities();
        $testimonials = $this->getTestimonials();
        $extracurriculars = $this->getExtracurriculars();

        return view('pages.home', compact('latestNews', 'programs', 'agenda', 'gallery', 'facilities', 'testimonials', 'video', 'profile', 'extracurriculars'));
    }

    private function getAgenda()
    {
        return \App\Models\Agenda::query()
            ->orderBy('date', 'desc')
            ->take(4)->get()->map(function($item) {
            $date = \Carbon\Carbon::parse($item->date);
            return [
                'title' => $item->title,
                'date' => $item->date,
                'day' => $date->format('d'),
                'month' => $date->translatedFormat('M'),
                'time' => $item->time,
                'location' => $item->location,
                'is_past' => $date->endOfDay()->isPast(),
            ];
        })->toArray();
    }

    private function getGallery()
    {
        return \App\Models\Gallery::latest()->take(6)->get()->map(function($item) {
            return [
                'src' => filter_var($item->image_path, FILTER_VALIDATE_URL) ? $item->image_path : asset('storage/' . $item->image_path),
                'title' => $item->title
            ];
        })->toArray();
    }

    private function getFacilities()
    {
        return \App\Models\Facility::latest()->take(3)->get()->map(function($item) {
            return [
                'title' => $item->title,
                'desc' => $item->description,
                'icon' => $item->icon ?: 'building-2',
                'image' => filter_var($item->image_path, FILTER_VALIDATE_URL) ? $item->image_path : asset('storage/' . $item->image_path),
            ];
        })->toArray();
    }

    private function getTestimonials()
    {
        return \App\Models\Testimonial::latest()->take(6)->get()->map(function($item) {
            return [
                'quote' => $item->quote,
                'name' => $item->name,
                'role' => $item->role,
                'avatar' => $item->avatar_path ? (filter_var($item->avatar_path, FILTER_VALIDATE_URL) ? $item->avatar_path : asset('storage/' . $item->avatar_path)) : 'https://ui-avatars.com/api/?name='.urlencode($item->name).'&background=random',
            ];
        })->toArray();
    }

    private function getExtracurriculars()
    {
        return \App\Models\Extracurricular::orderBy('name', 'asc')->take(6)->get()->map(function($item) {
            return [
                'name' => $item->name,
                'desc' => $item->description,
                'icon' => $item->icon ?: 'activity', 
                'image' => $item->image_path ? (filter_var($item->image_path, FILTER_VALIDATE_URL) ? $item->image_path : asset('storage/' . $item->image_path)) : null,
            ];
        })->toArray();
    }
}
