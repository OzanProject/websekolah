<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TestimonialImport;
use App\Exports\TestimonialTemplateExport;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'quote' => 'required|array',
            'quote.id' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'role', 'quote']);

        if ($request->hasFile('avatar')) {
            $data['avatar_path'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('avatar'), 'testimonials');
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil ditambahkan');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'quote' => 'required|array',
            'quote.id' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'role', 'quote']);

        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar_path && Storage::disk('public')->exists($testimonial->avatar_path)) {
                Storage::disk('public')->delete($testimonial->avatar_path);
            }
            $data['avatar_path'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('avatar'), 'testimonials');
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil diperbarui');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->avatar_path && Storage::disk('public')->exists($testimonial->avatar_path)) {
            Storage::disk('public')->delete($testimonial->avatar_path);
        }
        
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new TestimonialImport, $request->file('file'));
            return redirect()->route('admin.testimonials.index')->with('success', 'Data testimoni berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->route('admin.testimonials.index')->with('error', 'Terjadi kesalahan saat mengimport: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new TestimonialTemplateExport, 'Template_Import_Testimoni.xlsx');
    }
}
