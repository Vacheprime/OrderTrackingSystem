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

        return response()->file($path);
    }
}
