<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class ImageService
{
    /**
     * Mengunggah gambar, meresize jika terlalu besar, lalu mengonversi ke format WebP.
     *
     * @param UploadedFile $file File gambar dari request
     * @param string $folder Folder tujuan di dalam disk 'public'
     * @param int $quality Kualitas kompresi WebP (0-100)
     * @param int $maxWidth Lebar maksimal gambar
     * @return string Path gambar yang disimpan
     */
    public static function uploadAndConvertToWebp(
        UploadedFile $file, 
        string $folder, 
        int $quality = 80,
        int $maxWidth = 1600
    ): string {
        $mime = $file->getMimeType();
        
        // Jika bukan gambar, simpan langsung
        if (!str_starts_with($mime, 'image/')) {
            return $file->store($folder, 'public');
        }

        try {
            // Gunakan driver GD bawaan PHP (ditulis mixed agar IDE tidak memberikan false warning)
            /** @var mixed $manager */
            $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $image = $manager->decode($file->getRealPath());
            
            // Menggunakan Str::random ala Laravel
            $filename = Str::random(40) . '.webp';
            $path = $folder . '/' . $filename;
            
            // Skala dinamis berdasarkan parameter
            $image->scaleDown($maxWidth, $maxWidth);
            
            $encoded = $image->encode(new \Intervention\Image\Encoders\WebpEncoder($quality));
            Storage::disk('public')->put($path, (string) $encoded);
            
            return $path;
            
        } catch (\Exception $e) {
            // Mencatat error ke file log Laravel (storage/logs/laravel.log)
            Log::warning('Gagal mengonversi gambar ke WebP: ' . $e->getMessage());
            
            // Fallback: simpan asli
            return $file->store($folder, 'public');
        }
    }
}
