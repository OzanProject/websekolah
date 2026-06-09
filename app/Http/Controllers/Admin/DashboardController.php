<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ppdb;
use App\Models\News;
use App\Models\Program;
use App\Models\Facility;
use App\Models\Agenda;

class DashboardController extends Controller
{
    public function index()
    {
        // Summary Counts
        $countPpdb = Ppdb::count();
        $countNews = News::count();
        $countProgram = Program::count();
        $countFacility = Facility::count();

        // Recent Items
        $recentPpdb = Ppdb::orderBy('created_at', 'desc')->take(5)->get();
        $recentNews = News::orderBy('created_at', 'desc')->take(5)->get();
        $recentAgenda = Agenda::orderBy('date', 'desc')->take(5)->get(); // Assuming 'date' column exists for Agenda based on previous standard setups

        return view('admin.dashboard', compact(
            'countPpdb', 'countNews', 'countProgram', 'countFacility',
            'recentPpdb', 'recentNews', 'recentAgenda'
        ));
    }
}
