<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolProfile;
use Illuminate\Support\Facades\Storage;

class GeneralSettingController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $profile = SchoolProfile::first() ?? new SchoolProfile();
        return view('admin.settings.general', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'school_name' => 'nullable|string|max:255',
            'school_tagline' => 'nullable|string|max:255',
            'school_description' => 'nullable|string|max:1000',
            'google_site_verification' => 'nullable|string',
            'google_analytics' => 'nullable|string',
            'google_tag_manager' => 'nullable|string',
            'school_npsn' => 'nullable|string|max:50',
            'school_nss' => 'nullable|string|max:50',
            'school_accreditation' => 'nullable|string|max:50',
            'tinymce_api_key' => 'nullable|string|max:255',
            'school_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profile = SchoolProfile::first();
        if (!$profile) {
            $profile = new SchoolProfile();
        }

        $data = $request->only([
            'school_name', 
            'school_tagline', 
            'school_description',
            'google_site_verification',
            'google_analytics',
            'google_tag_manager',
            'school_npsn', 
            'school_nss', 
            'school_accreditation',
            'tinymce_api_key',
            'hero_btn1_text',
            'hero_btn1_url',
            'hero_btn2_text',
            'hero_btn2_url',
        ]);

        if ($request->hasFile('school_logo')) {
            // Hapus logo lama jika ada
            if ($profile->school_logo && Storage::disk('public')->exists($profile->school_logo)) {
                Storage::disk('public')->delete($profile->school_logo);
            }
            
            // Simpan logo baru
            $path = \App\Services\ImageService::uploadAndConvertToWebp($request->file('school_logo'), 'images/logo');
            $data['school_logo'] = $path;
        }

        // Proses Hero Slides
        if ($request->has('slides')) {
            $slidesData = [];
            foreach ($request->input('slides') as $index => $slideInput) {
                $slideData = [
                    'tag' => $slideInput['tag'] ?? '',
                    'title' => $slideInput['title'] ?? '',
                    'desc' => $slideInput['desc'] ?? '',
                    'image' => $slideInput['old_image'] ?? '',
                ];

                // Jika ada file gambar baru untuk slide ini
                if ($request->hasFile("slides.{$index}.image")) {
                    // Hapus gambar lama jika ada
                    if (!empty($slideData['image']) && Storage::disk('public')->exists($slideData['image'])) {
                        Storage::disk('public')->delete($slideData['image']);
                    }
                    $path = \App\Services\ImageService::uploadAndConvertToWebp($request->file("slides.{$index}.image"), 'images/hero');
                    $slideData['image'] = $path;
                }

                $slidesData[] = $slideData;
            }
            $data['hero_slides'] = $slidesData;
        }

        $profile->fill($data);
        $profile->save();

        return redirect()->back()->with('success', 'Pengaturan Umum berhasil diperbarui.');
    }
}
