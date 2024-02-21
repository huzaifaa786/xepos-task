<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public function storeLogo($logoImage)
    {
        if ($logoImage != null && $logoImage != '') {


            $thumbnailFilePath = $this->storeFile($logoImage, 'public/logos');
            return $this->getFileUrl($thumbnailFilePath);
        } else {
            return null;
        }
    }

    private function storeFile($file, $storagePath)
    {
        $filenameWithExt = $file->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;

        return $file->storeAs($storagePath, $fileNameToStore);
    }

    private function getFileUrl($filePath)
    {
        return asset(Storage::url($filePath));
    }
}
