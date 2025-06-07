<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display the image.
     *
     * @param  string  $imageName
     * @return \Illuminate\Http\Response
     */
    public function show(string $imageName)
    {
        $path = storage_path('app/private/fabrication_plan_images/' . $imageName);

        if (!file_exists($path)) {
            abort(404, 'Image not found.');
        }

        // Define cache control headers to prevent caching
        $cacheControlHeaders = [
            "Cache-Control" => "no-store, no-cache, must-revalidate, max-age=0",
            "Pragma" => "no-cache",
            "Expires" => "0",
        ];

        return response()->file($path, $cacheControlHeaders);
    }
}
