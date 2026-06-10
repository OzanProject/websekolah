<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Extracurricular;
use Illuminate\Support\Facades\Storage;

class ExtracurricularController extends Controller
{
    public function index()
    {
        $extracurriculars = Extracurricular::latest()->get();
        return view('admin.extracurriculars.index', compact('extracurriculars'));
    }

    public function create()
    {
        return view('admin.extracurriculars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|array',
            'name.id' => 'required|string|max:255',
            'description' => 'nullable|array',
            'icon' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'icon']);

        if ($request->hasFile('image')) {
            $data['image_path'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('image'), 'extracurriculars');
        }

        Extracurricular::create($data);

        return redirect()->route('admin.extracurriculars.index')->with('success', 'Ekstrakurikuler berhasil ditambahkan');
    }

    public function edit(Extracurricular $extracurricular)
    {
        return view('admin.extracurriculars.edit', compact('extracurricular'));
    }

    public function update(Request $request, Extracurricular $extracurricular)
    {
        $request->validate([
            'name' => 'required|array',
            'name.id' => 'required|string|max:255',
            'description' => 'nullable|array',
            'icon' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'icon']);

        if ($request->hasFile('image')) {
            if ($extracurricular->image_path && Storage::disk('public')->exists($extracurricular->image_path)) {
                Storage::disk('public')->delete($extracurricular->image_path);
            }
            $data['image_path'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('image'), 'extracurriculars');
        }

        $extracurricular->update($data);

        return redirect()->route('admin.extracurriculars.index')->with('success', 'Ekstrakurikuler berhasil diperbarui');
    }

    public function destroy(Extracurricular $extracurricular)
    {
        if ($extracurricular->image_path && Storage::disk('public')->exists($extracurricular->image_path)) {
            Storage::disk('public')->delete($extracurricular->image_path);
        }
        
        $extracurricular->delete();

        return redirect()->route('admin.extracurriculars.index')->with('success', 'Ekstrakurikuler berhasil dihapus');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:extracurriculars,id',
        ]);

        $items = Extracurricular::whereIn('id', $request->ids)->get();

        foreach ($items as $item) {
            /** @var \App\Models\Extracurricular $item */
            if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
                Storage::disk('public')->delete($item->image_path);
            }
            $item->delete();
        }

        return response()->json(['success' => true, 'message' => 'Ekstrakurikuler terpilih berhasil dihapus.']);
    }
}
