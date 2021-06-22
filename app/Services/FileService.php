<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
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
        if (config('app.is_heroku')) {
            $httpsUrl = cloudinary()->upload($avatarFile->getRealPath())->getSecurePath();
            return $httpsUrl;
        }
        $filename = date('YmdHis') . Str::random(20);
        $avatarFile->storeAs('public/avatars', $filename);
        return $filename;
    }

    /**
     * backup database into database/seeders folder
     *
     * @param string $date
     * @return array
     */
    public function backupDatabase(string $date = null)
    {
        try {
            if (is_null($date))
                $date = date('Y-m-d');
            $query   = "SELECT table_name FROM information_schema.tables WHERE table_type = 'base table' AND table_schema='" . config('database.connections.mysql.database') . "';";
            $results = DB::select($query);
            $tables  = collect($results)->pluck('table_name')->toArray();
            $folder = str_replace('/', '\\', database_path('seeders/backups-' . $date));
            if (!file_exists($folder)) {
                mkdir($folder);
            }
            foreach ($tables as $table) {
                $json    = DB::table($table)->get()->toJson();
                $filepath = $folder . '/' . $table . '.json';
                file_put_contents($filepath, $json);
            }
            return [true, 'Backup database successfull. Store in ' . $folder];
        } catch (Exception $e) {
            return [false, $e->getMessage()];
        }
    }

    /**
     * restore database from database/seeders folder
     *
     * @param string $date
     * @return array
     */
    public function restoreDatabase(string $date)
    {
        try {
            $folder = 'seeders/backups-' . ($date ?? date('Y-m-d'));
            if (!Storage::disk('database')->exists($folder)) {
                return [false, 'Folder ' . str_replace('/', '\\', database_path($folder)) . ' doesn\'t exist'];
            }
            $files = Storage::disk('database')->files($folder);
            Schema::disableForeignKeyConstraints();
            foreach ($files as $path) {
                $table_name = str_replace($folder . '/', '', $path);
                $table_name = str_replace('.json', '', $table_name);
                $json       = file_get_contents(database_path($path));
                $jsonArray  = json_decode($json, true);
                DB::table($table_name)->truncate();
                DB::table($table_name)->insert($jsonArray);
            }
            return [true, 'Restore database successfull from ' . $folder];
        } catch (Exception $e) {
            return [false, $e->getMessage()];
        }
    }
}
