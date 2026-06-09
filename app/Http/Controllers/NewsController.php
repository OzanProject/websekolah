<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with(['category', 'author'])->orderBy('date', 'desc')->paginate(9);
        return view('pages.berita.index', compact('news'));
    }

    public function show($slug)
    {
        $news = News::with(['category', 'author'])->where('slug', $slug)->firstOrFail();
        $relatedNews = News::with(['category'])->where('id', '!=', $news->id)->orderBy('date', 'desc')->take(3)->get();
        return view('pages.berita.show', compact('news', 'relatedNews'));
    }
}
