<?php

namespace App\Http\Controllers;

use App\Jobs\EditFileJob;
use App\Jobs\ShellJob;
use App\Services\CommandService;
use App\Services\DatabaseService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UbuntuController extends Controller
{

    private CommandService $commandService;
    private DatabaseService $dbService;
    private FileService $fileService;

    public function __construct()
    {
        $this->middleware('can:Ubuntu');
        $this->commandService = new CommandService();
        $this->dbService = new DatabaseService();
        $this->fileService = new FileService();
    }

    public function index(Request $request)
    {

        if ($request->query('redirect_folder')) {
            $path = $request->query('redirect_folder');
            return redirect()->route('ubuntu.index', ['folder' => encrypt($path)]);
        }

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
        $parentPath = dirname($path);

        $phps = $this->fileService->getAllPhp();

        $supervisors = $this->fileService->getSupervisor();

        $isEnvExists = false;
        $foldersWww = [];
        $filesWww = [];
        if (File::exists($path)) {
            $filesWww   = File::files($path, true);
            foreach ($filesWww as $f) {
                if ($f->getFilename() == '.env') {
                    $isEnvExists = true;
                }
            }
            $foldersWww = File::directories($path);
        }

        $isGit = File::exists($path . '/.git');
        $isLaravel = File::exists($path . '/composer.json');

        $i = 0;
        foreach ($files as $file) {
            File::exists('/etc/nginx/sites-enabled/' . $file->getFilename()) ? $files[$i]->enabled = true : $files[$i]->enabled = false;
            $content = $files[$i]->content = file_get_contents($file->getPathname());
            $domain =  explode('server_name', $content)[1];
            $domain = trim(explode(';', $domain)[0]);
            $files[$i]->domain = $domain ?? null;
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
            return $this->dbService->getAllRowMySqlAsJson($database, $table);
        } else if ($database && $table) {
            $result    = $this->dbService->getAllRowMySql($database, $table);
            $rows      = $result['rows'];
            $structure = $result['structure'];
        } else if ($database) {
            $tables = $this->dbService->getAllTableMySql($database);
        } else {
            $databases = $this->dbService->getAllDbMySql();
        }


        $nginxStatus = shell_exec('service nginx status');
        $supervisorStatus = shell_exec('service supervisor status');

        return view('stisla.ubuntu.index', [
            'files'            => $files,
            'filesWww'         => $filesWww,
            'foldersWww'       => $foldersWww,
            'path'             => $path,
            'isGit'            => $isGit,
            'isLaravel'        => $isLaravel,
            'databases'        => $databases,
            'tables'           => $tables,
            'rows'             => $rows,
            'structure'        => $structure,
            'parentPath'       => $parentPath,
            'nginxStatus'      => $nginxStatus,
            'phps'             => $phps,
            'supervisors'      => $supervisors,
            'supervisorStatus' => $supervisorStatus,
            'isEnvExists'      => $isEnvExists,
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

    public function editRow($database, $table, $id)
    {
        $d = DB::table($database . '.' . $table)->where('id', $id)->first();

        if (!$d) abort(404);

        $d = json_decode(json_encode($d), true);

        return view('stisla.ubuntu.form-row', [
            'title'      => __('MySQL Database'),
            'fullTitle'  => __('MySQL Database'),
            'routeIndex' => route('ubuntu.index'),
            'action'     => route('ubuntu.update-row', [$database, $table, $id]),
            'd'          => $d,
            'keys'       => array_keys($d),
        ]);
    }

    public function updateRow($database, $table, $id, Request $request)
    {
        $data = ($request->except('_token', '_method'));
        DB::table($database . '.' . $table)->where('id', $id)->update($data);
        return redirect()->back()->with('successMessage', 'Berhasil memperbarui data');
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
        if (request('as')) {
            $folder = str_replace(basename($pathnameD), '', $pathnameD);
            EditFileJob::dispatch($folder . request('as'), $content);
            return redirect()->back()->with('successMessage', 'Berhasil menduplikasi file ke .env');
        } else {
            EditFileJob::dispatch($pathnameD . '_copy', $content);
            return redirect()->back()->with('successMessage', 'Berhasil menduplikasi file');
        }
    }

    public function destroy($pathname)
    {
        $pathnameD = decrypt($pathname);
        $command = $this->commandService->deleteFile($pathnameD);
        ShellJob::dispatch($command);

        return redirect()->back()->with('successMessage', 'Berhasil menghapus file');
    }

    public function toggleEnabled($pathname, $nextStatus)
    {
        $pathnameD = decrypt($pathname);
        if ($nextStatus === 'true') {
            $command = $this->commandService->enableNginxConf($pathnameD);
            ShellJob::dispatch($command);
            return redirect()->back()->with('successMessage', 'Berhasil menjalankan command ' . $command);
        } else if ($nextStatus === 'false') {
            $command = $this->commandService->disableNginxConf($pathnameD);
            ShellJob::dispatch($command);
            return redirect()->back()->with('successMessage', 'Berhasil menjalankan command ' . $command);
        }
        abort(404);
    }

    public function gitPull($pathname)
    {

        $pathnameD = decrypt($pathname);


        $command = 'git config --global --add safe.directory ' . $pathnameD . ' 2>&1';
        $output = shell_exec($command);
        return $output;
        // $command = 'git config --global --add safe.directory ' . $pathnameD . ' && /usr/bin/git pull origin 2>&1';
        ShellJob::dispatch($command, $pathnameD);

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
        $this->dbService->createMySqlDb($schemaName);
        return redirect()->back()->with('successMessage', 'Berhasil membuat database ' . $schemaName);
    }

    public function nginx(Request $request)
    {
        $command = $this->commandService->nginx($request->nginx);
        ShellJob::dispatch($command);
        return redirect()->back()->with('successMessage', 'Berhasil menjalankan command  ' . $command);
    }

    public function deleteRow($database, $table, $id)
    {
        $this->dbService->deleteRow($database, $table, $id);
        return redirect()->back()->with('successMessage', 'Berhasil menghapus data');
    }

    public function phpFpm($version, $action)
    {
        $command = $this->commandService->phpFpm($version, $action);
        ShellJob::dispatch($command);
        return redirect()->back()->with('successMessage', 'Berhasil menjalankan command  ' . $command);
    }

    public function supervisor($action)
    {
        $command = $this->commandService->supervisor($action);
        ShellJob::dispatch($command);
        return redirect()->back()->with('successMessage', 'Berhasil menjalankan command  ' . $command);
    }
}
