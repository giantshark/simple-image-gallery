<?php

namespace App\Container\Gallery\Services;

use App\Container\Gallery\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class UploadService {

    public function uploadImage($user, $file)
    {

        $storedFile = $this->storeImage($file);
        return Gallery::create([
            'user_id' => $user->id,
            'size' => $file->getSize(),
            'name' => $storedFile['filename'],
            'mimes' => $storedFile['mimes'],
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType()
        ]);
    }

    public function storeImage($file)
    {
        $fileName = uniqid('img').rand(1000,9999);
        $mimes = $file->getClientOriginalExtension();
        Storage::putFileAs('image', $file, $fileName.'.'.$mimes, 'public');
        return [
            'filename' => $fileName,
            'mimes' => $mimes
        ];
    }

    public function removeImage($user, $imageId)
    {
        $image = Gallery::where('id', $imageId)->where('user_id', $user->id)->first();
        if ($image && $image->delete()) {
            return true;
        }
        return false;
    }

}