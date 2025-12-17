<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function upload(ImageRequest $request)
    {
        $user= auth()->user();

        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
        Storage::disk('public')->delete($user->profile_picture);
    }
        $filename = time() . '_' . $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('images', $filename, 'public');
         $user->update([
        'profile_picture' => $path, 
    ]);
        return back()->with('image', 'Image upload sucessfull.');
}
}
