<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Page;

class SitemapController extends Controller
{
    public function index()
    {
        $news = News::orderBy('date', 'desc')->get();
        $pages = Page::where('is_active', true)->get();

        return response()->view('sitemap', [
            'news' => $news,
            'pages' => $pages,
        ])->header('Content-Type', 'text/xml');
    }
}
