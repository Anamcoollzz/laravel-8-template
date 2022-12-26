<?php

namespace App\Http\Controllers;

use App\Jobs\EditFileJob;
use App\Jobs\ShellJob;
use App\Services\CommandService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UbuntuController extends Controller
{

    private CommandService $commandService;

    public function __construct()
    {
        $this->commandService = new CommandService();
    }

    public function index(Request $request)
    {
        if ($request->query('download')) {
            $path = decrypt($request->query('download'));
            return response()->download($path);
        }

        $files = collect([]);
        if (File::exists('/etc/nginx/sites-available')) {
            $files      = File::files('/etc/nginx/sites-available');
        }

        // $path       = '/Users/anamkun/Documents/PROJEK/ME';
        $path = '/var/www';
        if ($request->query('folder')) {
            $path = decrypt($request->query('folder'));
        }

        $filesWww = [];
        $foldersWww = [];
        if (File::exists($path)) {
            $filesWww   = File::files($path, true);
            $foldersWww = File::directories($path);
        }
        $isGit = File::exists($path . '/.git');
        $isLaravel = File::exists($path . '/composer.json');

        $i = 0;
        foreach ($files as $file) {
            File::exists('/etc/nginx/sites-enabled/' . $file->getFilename()) ? $files[$i]->enabled = true : $files[$i]->enabled = false;
            $i++;
        }

        $databases = [];
        $tables    = [];
        $structure = [];
        $rows      = [];
        $database  = $request->query('database');
        $table     = $request->query('table');
        $action    = $request->query('action');
        if ($database && $table && $action == 'json') {
            $query = 'SELECT * FROM ' . $database . '.' . $table . ';';
            $rows = collect(DB::select($query));
            return ['count' => count($rows), 'rows' => $rows];
        } else if ($database && $table) {
            $query = 'SELECT COLUMN_NAME AS `column`, DATA_TYPE AS `type`, CHARACTER_MAXIMUM_LENGTH AS `length`, IS_NULLABLE AS `nullable`, COLUMN_DEFAULT AS `default`, COLUMN_COMMENT AS `comment` FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;';
            $structure = collect(DB::select($query, [$database, $table]));
            $query = 'SELECT * FROM ' . $database . '.' . $table . ' ORDER BY id desc;';
            $rows = collect(DB::select($query));
        } else if ($database) {
            $query = 'SELECT TABLE_NAME AS `table`, ROUND((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024, 2) AS `size_mb` FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? ORDER BY (DATA_LENGTH + INDEX_LENGTH) DESC;';
            $tables = collect(DB::select($query, [$database]));
            $tables = $tables->transform(function ($item) use ($database) {
                $item->total_row = DB::select('SELECT COUNT(*) as total_row FROM ' . $database . '.' . $item->table)[0]->total_row;
                return $item;
            })->sortByDesc('total_row')->values();
        } else {
            $query = 'SHOW DATABASES';
            $databases = collect(DB::select($query));
            $databases = $databases->transform(function ($item) {
                $item->total_table = DB::select('SELECT COUNT(*) as total_table FROM information_schema.TABLES WHERE table_schema = ?', [$item->Database])[0]->total_table;
                $query = 'SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS "size_mb" FROM information_schema.TABLES WHERE table_schema = ?';
                $item->size_mb = DB::select($query, [$item->Database])[0]->size_mb ?? 0;
                $item->database = $item->Database;
                return $item;
            })->sortBy('database')->values();
        }

        return view('stisla.ubuntu.index', [
            'files'      => $files,
            'filesWww'   => $filesWww,
            'foldersWww' => $foldersWww,
            'path'       => $path,
            'isGit'      => $isGit,
            'isLaravel'  => $isLaravel,
            'databases'  => $databases,
            'tables'     => $tables,
            'rows'       => $rows,
            'structure'  => $structure,
        ]);
    }

    public function edit($pathname)
    {
        $pathnameD = decrypt($pathname);
        $file = file_get_contents($pathnameD);

        return view('stisla.ubuntu.form', [
            'file'       => $file,
            'title'      => __('Ubuntu'),
            'fullTitle'  => __('Ubah File'),
            'routeIndex' => route('ubuntu.index'),
            'action'     => route('ubuntu.update', [$pathname]),
            'pathname'   => $pathnameD,
        ]);
    }

    public function update($pathname, Request $request)
    {
        $pathnameD = decrypt($pathname);
        EditFileJob::dispatch($pathnameD, $request->filename);

        if ($pathnameD !== request('pathname')) {
            $command = 'mv ' . $pathnameD . ' ' . request('pathname');
            ShellJob::dispatch($command);
            return redirect('/ubuntu')->with('successMessage', 'Berhasil memperbarui file');
        }

        return redirect()->back()->with('successMessage', 'Berhasil memperbarui file');
    }

    public function duplicate($pathname)
    {
        $pathnameD = decrypt($pathname);
        $content = file_get_contents($pathnameD);
        EditFileJob::dispatch($pathnameD . '_copy', $content);

        return redirect()->back()->with('successMessage', 'Berhasil menduplikasi file');
    }

    public function destroy($pathname)
    {
        $pathnameD = decrypt($pathname);
        $command = 'rm ' . $pathnameD;
        ShellJob::dispatch($command);

        return redirect()->back()->with('successMessage', 'Berhasil menghapus file');
    }

    public function toggleEnabled($pathname, $nextStatus)
    {
        $pathnameD = decrypt($pathname);
        if ($nextStatus === 'true') {
            $command = 'ln -s ' . $pathnameD . ' /etc/nginx/sites-enabled/';
            ShellJob::dispatch($command);
        } else if ($nextStatus === 'false') {
            $paths = explode('/', $pathnameD);
            $command = 'rm /etc/nginx/sites-enabled/' . end($paths);
            ShellJob::dispatch($command);
        }

        return redirect()->back()->with('successMessage', 'Berhasil menset enabled ke ' . $nextStatus);
    }

    public function gitPull($pathname)
    {

        $pathnameD = decrypt($pathname);

        $command = 'git config --global --add safe.directory ' . $pathnameD . ' 2>&1';
        // $command = 'git config --global --add safe.directory ' . $pathnameD . ' && /usr/bin/git pull origin 2>&1';
        ShellJob::dispatch($command, $pathnameD);

        // $commands = [];
        // $commands[] = 'chown -R www-agent:www-agent ' . $pathnameD . '/';
        // $commands[] = 'cd ' . $pathnameD;
        // $commands[] = 'git config --global --add safe.directory ' . $pathnameD;
        // $commands[] = '/usr/bin/git pull origin 2>&1';
        // $command = implode(' && ', $commands);
        // $output = shell_exec($command);
        // return $output;
        // ShellJob::dispatch($command);
        // ShellJob::dispatch($this->commandService->setLaravelPermission($pathnameD));

        return redirect()->back()->with('successMessage', 'Berhasil run command ' . $command);
    }

    public function setLaravelPermission($pathname)
    {
        $pathnameD = decrypt($pathname);

        ShellJob::dispatch($command = $this->commandService->setLaravelPermission($pathnameD));

        return redirect()->back()->with('successMessage', 'Berhasil run command ' . $command);
    }

    public function createDb()
    {
        $schemaName = request('database_name');
        $charset    = config("database.connections.mysql.charset", 'utf8mb4');
        $collation  = config("database.connections.mysql.collation", 'utf8mb4_unicode_ci');
        $query      = "CREATE DATABASE IF NOT EXISTS $schemaName CHARACTER SET $charset COLLATE $collation;";
        DB::statement($query);
        return redirect()->back()->with('successMessage', 'Berhasil membuat database ' . $schemaName);
    }

    public function nginx(Request $request)
    {
        $nginx = $request->nginx;
        if (!in_array($nginx, ['start', 'stop', 'restart', 'reload', 'status'])) {
            abort(404);
        }
        $command = "service nginx " . $nginx;
        ShellJob::dispatch($command);
        return redirect()->back()->with('successMessage', 'Berhasil menjalankan command  ' . $command);
    }
}
