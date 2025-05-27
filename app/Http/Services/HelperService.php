<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\Storage;

class HelperService
{
    public static function StoreImage($image)
    {
        $path = $image->store('images', 'public');
        return $path;
    }

    public static function getImageUrl($image)
    {
        return Storage::url($image);
    }

    public static function deleteImage($path)
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }
}