<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class OptimizeImages extends Command
{
    protected $signature = 'optimize:images';
    protected $description = 'Optimize and resize all uploaded images in storage/app/public to fix PageSpeed';

    public function handle()
    {
        $this->info('Memulai optimasi gambar...');
        $disk = Storage::disk('public');
        $files = $disk->allFiles();
        
        $count = 0;
        foreach ($files as $file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                continue;
            }

            $path = $disk->path($file);
            $this->optimizeImage($path, $ext);
            $count++;
        }
        $this->info("Selesai! Berhasil mengoptimasi $count gambar.");
    }

    private function optimizeImage($path, $ext)
    {
        $maxWidth = 800; // Resize to max 800px width
        
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                $img = @imagecreatefromjpeg($path);
                break;
            case 'png':
                $img = @imagecreatefrompng($path);
                break;
            case 'webp':
                $img = @imagecreatefromwebp($path);
                break;
            default:
                return;
        }

        if (!$img) return;

        $width = imagesx($img);
        $height = imagesy($img);
        
        $resized = false;
        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = floor($height * ($maxWidth / $width));
            $newImg = imagecreatetruecolor($newWidth, $newHeight);
            
            if ($ext == 'png' || $ext == 'webp') {
                imagealphablending($newImg, false);
                imagesavealpha($newImg, true);
                $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
                imagefilledrectangle($newImg, 0, 0, $newWidth, $newHeight, $transparent);
            }
            
            imagecopyresampled($newImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($img);
            $img = $newImg;
            $resized = true;
        }

        // Re-save with 70% quality to reduce file size significantly
        if ($ext == 'webp') {
            imagewebp($img, $path, 70);
        } elseif ($ext == 'jpg' || $ext == 'jpeg') {
            imagejpeg($img, $path, 70);
        } elseif ($ext == 'png') {
            imagepng($img, $path, 8); 
        }

        imagedestroy($img);
        
        $action = $resized ? 'Resized & Compressed' : 'Compressed';
        $this->info("[$action]: " . basename($path));
    }
}
