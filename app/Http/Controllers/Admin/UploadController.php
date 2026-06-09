<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Handle TinyMCE image upload.
     */
    public function tinymceUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,webp,mp4,webm,ogg,pdf,doc,docx,xls,xlsx|max:51200',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Upload the image using ImageService or manually
            // We use standard storage approach here, or ImageService if we want to convert to webp
            try {
                $mimeType = $file->getMimeType();
                $isImage = str_starts_with($mimeType, 'image/');

                if ($isImage && class_exists(\App\Services\ImageService::class)) {
                    $path = \App\Services\ImageService::uploadAndConvertToWebp($file, 'images/tinymce');
                    $url = asset('storage/' . $path);
                } else {
                    $folder = $isImage ? 'images/tinymce' : 'media/tinymce';
                    $path = $file->store($folder, 'public');
                    $url = asset('storage/' . $path);
                }

                return response()->json(['location' => $url]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }
}
