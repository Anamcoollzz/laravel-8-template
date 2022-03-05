<?php

use Illuminate\Support\Facades\File;

/**
 * getFileNamesFromDir
 *
 * @param string $path
 * @return \Illuminate\Support\Collection
 */
function getFileNamesFromDir(string $path)
{
    $files = File::files($path);
    $files = collect($files);
    $fileNames = $files->map(function (\Symfony\Component\Finder\SplFileInfo $file) {
        return $file->getRelativePathname();
    });
    return $fileNames;
}
