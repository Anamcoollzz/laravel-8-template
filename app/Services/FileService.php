<?php

namespace App\Services;

use App\Models\CrudExample;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{

    /**
     * execute upload
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folderName
     * @return string
     */
    public function executeUpload(\Illuminate\Http\UploadedFile $file, string $folderName)
    {
        if (config('app.is_heroku')) {
            $httpsUrl = cloudinary()->upload($file->getRealPath())->getSecurePath();
            return $httpsUrl;
        }
        $filename = date('YmdHis') . Str::random(20) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/' . $folderName, $filename);
        return asset('storage/' . $folderName . '/' . $filename);
    }

    /**
     * execute delete from storage
     *
     * @param string $filepath
     * @return bool
     */
    public function executeDeleteFromStorage(string $filepath)
    {
        $exist    = Storage::exists($filepath);
        if ($exist) {
            Storage::delete($filepath);
            return true;
        }
        return false;
    }

    /**
     * upload avatar file
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function uploadAvatar(\Illuminate\Http\UploadedFile $file)
    {
        return $this->executeUpload($file, 'avatars');
    }

    /**
     * upload file crud example
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function uploadCrudExampleFile(\Illuminate\Http\UploadedFile $file)
    {
        return $this->executeUpload($file, 'crud-examples');
    }

    /**
     * delete file crud example
     *
     * @param CrudExample $crudExample
     * @return bool
     */
    public function deleteCrudExampleFile(CrudExample $crudExample)
    {
        $filepath = 'public/crud-examples/' . $crudExample->file;
        return $this->executeDeleteFromStorage($filepath);
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

    /**
     * upload favicon file
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function uploadFavicon(\Illuminate\Http\UploadedFile $file)
    {
        return $this->executeUpload($file, 'favicon');
    }

    /**
     * upload logo file
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function uploadLogo(\Illuminate\Http\UploadedFile $file)
    {
        return $this->executeUpload($file, 'logo');
    }

    /**
     * upload stisla bg login file
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function uploadStislaBgLogin(\Illuminate\Http\UploadedFile $file)
    {
        return $this->executeUpload($file, 'stisla-bg-login');
    }

    /**
     * upload stisla bg home file
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function uploadStislaBgHome(\Illuminate\Http\UploadedFile $file)
    {
        return $this->executeUpload($file, 'stisla-bg-home');
    }

    /**
     * download collection as json file
     *
     * @param Collection $collection
     * @param string $filename
     * @return Response
     */
    public function downloadJson(Collection $collection, string $filename)
    {
        $json = $collection->toJson();
        $path = 'temp/json/' . $filename;
        Storage::put($path, $json);
        $path = storage_path('app/' . $path);
        return response()->download($path)->deleteFileAfterSend(true);
    }
}
