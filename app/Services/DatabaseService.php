<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseService
{

    private $folder;
    private $folderName;

    /**
     * DatabaseService constructor.
     */
    public function __construct()
    {
        $this->folderName = 'database-backups';
        $this->folder = storage_path('app/public/' . $this->folderName);
    }

    /**
     * backup mysql database
     *
     * @return void
     */
    public function backupMysql()
    {
        $this->checkFolder();

        $filename = 'backup-db-' . date('Y-m-d-H-i-s') . '.sql';
        $path = $this->folder . '/' . $filename;
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $database = config('database.connections.mysql.database');
        $command = "mysqldump --user={$username} --password={$password} {$database} > {$path}";
        $returnVar = NULL;
        $output = NULL;
        exec($command, $output, $returnVar);

        $commandZip = "cd {$this->folder} && zip -r {$filename}.zip {$filename}";
        $returnVarZip = NULL;
        $outputZip = NULL;
        exec($commandZip, $outputZip, $returnVarZip);

        $commandDelete = "cd {$this->folder} && rm {$filename}";
        $returnVarDelete = NULL;
        $outputDelete = NULL;
        exec($commandDelete, $outputDelete, $returnVarDelete);

        return $returnVar;
    }

    /**
     * backup daily mysql
     *
     * @return void
     */
    public function backupDailyMysql()
    {
        $today = date('Y-m-d');
        $data = $this->getAllBackupMysql();
        $data = collect($data)->filter(function ($item) use ($today) {
            return Str::contains($item, $today);
        })->sort()->reverse();
        if ($data->count() === 0) {
            $this->backupMysql();
        }
    }

    /**
     * get all backup mysql database
     *
     * @return Collection
     */
    public function getAllBackupMysql()
    {
        $files = Storage::files('public/' . $this->folderName);
        $data = collect($files)->sort()->reverse()
            ->map(function ($item) {
                return [
                    'path'       => $item,
                    'name'       => basename($item),
                    'url'        => asset(Storage::url($item)),
                    'size'       => $size = Storage::size($item),
                    'size_on_mb' => round($size / 1024 / 1024, 2),
                    'size_on_kb' => round($size / 1024, 2),
                    'size_on_gb' => round($size / 1024 / 1024 / 1024, 2),
                ];
                return $item;
            })->values();
        return $data;
    }

    /**
     * check folder is exist
     *
     * @return void
     */
    private function checkFolder()
    {
        if (!file_exists($this->folder)) {
            Storage::makeDirectory('public/' . $this->folderName);
        }
    }

    /**
     * restore mysql database
     *
     * @param $filename
     * @return void
     */
    public function restoreMysql($filename)
    {

        $path = $this->folder . '/' . $filename;
        $sqlPath = str_replace('.zip', '', $path);

        // unzip first for temp
        $commandUnZip = "cd {$this->folder} && unzip {$filename}";
        $returnVarUnZip = NULL;
        $outputUnZip = NULL;
        exec($commandUnZip, $outputUnZip, $returnVarUnZip);

        // restore database
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $database = config('database.connections.mysql.database');
        $command = "mysql --user={$username} --password={$password} {$database} < {$sqlPath}";
        $returnVar = NULL;
        $output = NULL;
        exec($command, $output, $returnVar);

        // delete sql temp file
        $commandDeleteZip = "rm {$sqlPath}";
        $returnVarDeleteZip = NULL;
        $outputDeleteZip = NULL;
        exec($commandDeleteZip, $outputDeleteZip, $returnVarDeleteZip);

        return $returnVar;
    }

    /**
     * delete mysql database
     *
     * @param $filename
     * @return void
     */
    public function deleteMysql($filename)
    {
        return Storage::delete('public/' . $this->folderName . '/' . $filename);
    }
}
