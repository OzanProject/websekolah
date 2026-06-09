<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\NewsImport;
use App\Exports\NewsTemplateExport;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest('date')->get();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|array',
            'title.id' => 'required|string|max:255',
            'content' => 'required|array',
            'content.id' => 'required',
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title['id']) . '-' . time();
        $data['author_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('image'), 'news');
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|array',
            'title.id' => 'required|string|max:255',
            'content' => 'required|array',
            'content.id' => 'required',
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->title['id'] !== $news->getTranslation('title', 'id')) {
            $data['slug'] = Str::slug($request->title['id']) . '-' . time();
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }
            $data['image'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('image'), 'news');
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy(News $news)
    {
        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }
        
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:news,id',
        ]);

        $newsItems = News::whereIn('id', $request->ids)->get();

        foreach ($newsItems as $news) {
            /** @var \App\Models\News $news */
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }
            $news->delete();
        }

        return response()->json(['success' => true, 'message' => 'Berita terpilih berhasil dihapus.']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new NewsImport, $request->file('file'));
            return redirect()->route('admin.news.index')->with('success', 'Data berita berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->route('admin.news.index')->with('error', 'Terjadi kesalahan saat mengimport: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new NewsTemplateExport, 'Template_Import_Berita.xlsx');
    }
}
