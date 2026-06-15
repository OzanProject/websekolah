<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolProfile;

class PpdbSettingController extends Controller
{
    /**
     * Show the form for editing PPDB settings.
     */
    public function edit()
    {
        $profile = SchoolProfile::first() ?? new SchoolProfile();
        $sections = \App\Models\FormSection::with('fields')->orderBy('order_weight')->get();
        $requirements = \App\Models\FormRequirement::orderBy('order_weight')->get();
        return view('admin.settings.ppdb', compact('profile', 'sections', 'requirements'));
    }

    /**
     * Update the PPDB settings in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'ppdb_title' => 'nullable|string|max:255',
            'ppdb_year' => 'nullable|string|max:255',
            'ppdb_description' => 'nullable|string',
            'ppdb_slug' => 'required|string|max:100|regex:/^[a-zA-Z0-9\-]+$/',
            'ppdb_button_text' => 'nullable|string|max:100',
        ]);

        $profile = SchoolProfile::first();
        if (!$profile) {
            $profile = new SchoolProfile();
        }

        $data = $request->only([
            'ppdb_title',
            'ppdb_year',
            'ppdb_description',
            'ppdb_slug',
            'ppdb_button_text',
        ]);
        
        $data['ppdb_active'] = $request->has('ppdb_active');

        $profile->fill($data);
        $profile->save();

        return redirect()->back()->with('success', 'Pengaturan PPDB berhasil diperbarui.');
    }
}
