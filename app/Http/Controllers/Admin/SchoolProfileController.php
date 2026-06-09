<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolProfile;

class SchoolProfileController extends Controller
{
    public function edit()
    {
        // Ambil profil sekolah pertama (karena kita hanya butuh 1 baris)
        $profile = SchoolProfile::first();
        
        // Jika karena suatu alasan belum ada, buatkan otomatis
        if (!$profile) {
            $profile = SchoolProfile::create([
                'stat_student' => 0,
                'stat_teacher' => 0,
                'stat_class' => 0,
                'stat_achievement' => 0,
            ]);
        }

        return view('admin.profiles.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'visi' => 'required|array',
            'visi.id' => 'required|string',
            'misi' => 'nullable|array',
            'misi.id' => 'nullable|array',
            'misi.id.*' => 'nullable|string',
            'stat_student' => 'required|integer',
            'stat_teacher' => 'required|integer',
            'stat_class' => 'required|integer',
            'stat_achievement' => 'required|integer',
            
            'kepsek_name' => 'nullable|string|max:255',
            'kepsek_image' => 'nullable|image|max:2048',
            'sambutan_content' => 'nullable|array',
            
            'contact_address' => 'nullable|string',
            'contact_phone' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'contact_hours' => 'nullable|string',
            'contact_map' => 'nullable|string',
            
            'social_facebook' => 'nullable|url',
            'social_instagram' => 'nullable|url',
            'social_youtube' => 'nullable|url',
        ]);

        $profile = SchoolProfile::first();
        
        // Buang misi yang kosong/null jika ada untuk setiap bahasa
        $misiProcessed = [];
        foreach(['id', 'en', 'ar'] as $loc) {
            if (isset($request->misi[$loc]) && is_array($request->misi[$loc])) {
                $filtered = array_values(array_filter($request->misi[$loc], function($val) {
                    return !empty($val);
                }));
                if(!empty($filtered)) {
                    $misiProcessed[$loc] = $filtered;
                }
            }
        }

        // Data yang akan diupdate
        $data = [
            'visi' => $request->visi,
            'misi' => $misiProcessed,
            'stat_student' => $request->stat_student,
            'stat_teacher' => $request->stat_teacher,
            'stat_class' => $request->stat_class,
            'stat_achievement' => $request->stat_achievement,
            
            'kepsek_name' => $request->kepsek_name,
            'sambutan_content' => $request->sambutan_content,
            'contact_address' => $request->contact_address,
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->contact_email,
            'contact_hours' => $request->contact_hours,
            'contact_map' => $request->contact_map,
            'social_facebook' => $request->social_facebook,
            'social_instagram' => $request->social_instagram,
            'social_youtube' => $request->social_youtube,
        ];

        // Handle File Upload
        if ($request->hasFile('kepsek_image')) {
            // Delete old image if exists
            if ($profile->kepsek_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($profile->kepsek_image);
            }
            $data['kepsek_image'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('kepsek_image'), 'profiles');
        }

        $profile->update($data);

        return redirect()->route('admin.profiles.edit')->with('success', 'Profil Sekolah berhasil diperbarui!');
    }
}
