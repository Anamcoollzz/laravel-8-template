<?php

namespace App\Services;

use Illuminate\Support\Str;

class FileService
{

    /**
     * upload avatar file
     *
     * @param \Illuminate\Http\UploadedFile $avatarFile
     * @return string
     */
    public function uploadAvatar(\Illuminate\Http\UploadedFile $avatarFile)
    {
        $filename = date('YmdHis') . Str::random(20);
        $avatarFile->storeAs('public/avatars', $filename);
        return $filename;
    }
}
