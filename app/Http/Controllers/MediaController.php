<?php

namespace App\Http\Controllers;

use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function create(Request $request)
    {
        $fileContent = $request->getContent();
        $imagePath = Str::random(40);

        Storage::disk('public')->put($imagePath, $fileContent);

        $media = Media::create(['path' => 'storage/' . $imagePath]);
        return new MediaResource($media);
    }

    public function remove(Request $request)
    {
    }
}