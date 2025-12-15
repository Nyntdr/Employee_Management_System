<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function upload(ImageRequest $request)
    {
        $filename = time() . '_' . $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('images', $filename, 'public');
        return back()->with('image', $path);

}
}
