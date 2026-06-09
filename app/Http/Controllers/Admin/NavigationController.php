<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function edit()
    {
        $profile = SchoolProfile::first();
        return view('admin.navigations.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nav_title' => 'nullable|array',
            'nav_title.*' => 'nullable|string',
            'nav_url' => 'nullable|array',
            'nav_url.*' => 'nullable|string',
            
            'link_title' => 'nullable|array',
            'link_title.*' => 'nullable|string',
            'link_url' => 'nullable|array',
            'link_url.*' => 'nullable|string',

            'header_navigations_json' => 'nullable|string',
        ]);

        $profile = SchoolProfile::first();

        // Proses footer navigations
        $navigations = [];
        if($request->has('nav_title') && is_array($request->nav_title)) {
            foreach($request->nav_title as $key => $title) {
                if(!empty($title) && !empty($request->nav_url[$key])) {
                    $navigations[] = [
                        'title' => $title,
                        'url' => $request->nav_url[$key]
                    ];
                }
            }
        }

        // Proses footer related links
        $related_links = [];
        if($request->has('link_title') && is_array($request->link_title)) {
            foreach($request->link_title as $key => $title) {
                if(!empty($title) && !empty($request->link_url[$key])) {
                    $related_links[] = [
                        'title' => $title,
                        'url' => $request->link_url[$key]
                    ];
                }
            }
        }

        // Proses header navigations
        $header_navigations = [];
        if($request->has('header_navigations_json') && !empty($request->header_navigations_json)) {
            $decoded = json_decode($request->header_navigations_json, true);
            if (is_array($decoded)) {
                $header_navigations = $decoded;
            }
        }

        $profile->update([
            'footer_navigations' => empty($navigations) ? null : $navigations,
            'footer_related_links' => empty($related_links) ? null : $related_links,
            'header_navigations' => empty($header_navigations) ? null : $header_navigations,
        ]);

        return redirect()->route('admin.navigations.edit')->with('success', 'Pengaturan navigasi berhasil diperbarui.');
    }
}
