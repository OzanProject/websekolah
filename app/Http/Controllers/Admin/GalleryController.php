<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GalleryImport;
use App\Exports\GalleryTemplateExport;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|array',
            'title.id' => 'nullable|string|max:255',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $baseTitle = $request->input('title.id');
        $images = $request->file('images');
        $count = count($images);

        foreach ($images as $index => $image) {
            $imagePath = \App\Services\ImageService::uploadAndConvertToWebp($image, 'galleries');
            
            // Jika ada judul, gunakan judul + nomor urut (jika upload lebih dari 1)
            // Jika tidak ada judul, gunakan nama asli file (tanpa ekstensi)
            $titleStr = $baseTitle 
                ? ($count > 1 ? $baseTitle . ' ' . ($index + 1) : $baseTitle) 
                : pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

            Gallery::create([
                'title' => ['id' => $titleStr],
                'image_path' => $imagePath
            ]);
        }

        return redirect()->route('admin.galleries.index')->with('success', $count . ' Foto galeri berhasil ditambahkan');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|array',
            'title.id' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['title']);

        if ($request->hasFile('image')) {
            if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            $data['image_path'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('image'), 'galleries');
        }

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Foto galeri berhasil diperbarui');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
            Storage::disk('public')->delete($gallery->image_path);
        }
        
        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Foto galeri berhasil dihapus');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:galleries,id',
        ]);

        $galleries = Gallery::whereIn('id', $request->ids)->get();

        foreach ($galleries as $gallery) {
            /** @var \App\Models\Gallery $gallery */
            if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            $gallery->delete();
        }

        return response()->json(['success' => true, 'message' => 'Foto terpilih berhasil dihapus.']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new GalleryImport, $request->file('file'));
            return redirect()->route('admin.galleries.index')->with('success', 'Data galeri berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->route('admin.galleries.index')->with('error', 'Terjadi kesalahan saat mengimport: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new GalleryTemplateExport, 'Template_Import_Galeri.xlsx');
    }
}
