<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->get();
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|array',
            'title.id' => 'required|string|max:255',
            'description' => 'nullable|array',
            'url' => 'required|url|max:255',
            'is_active' => 'boolean',
        ]);

        $isActive = $request->has('is_active');

        if ($isActive) {
            Video::where('is_active', true)->update(['is_active' => false]);
        }

        Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'is_active' => $isActive,
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil ditambahkan');
    }

    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|array',
            'title.id' => 'required|string|max:255',
            'description' => 'nullable|array',
            'url' => 'required|url|max:255',
            'is_active' => 'boolean',
        ]);

        $isActive = $request->has('is_active');

        if ($isActive && !$video->is_active) {
            Video::where('is_active', true)->update(['is_active' => false]);
        }

        $video->update([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'is_active' => $isActive,
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil diperbarui');
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil dihapus');
    }

    public function activate(Video $video)
    {
        Video::where('is_active', true)->update(['is_active' => false]);
        $video->update(['is_active' => true]);

        return redirect()->route('admin.videos.index')->with('success', 'Video telah diaktifkan');
    }
}
