<?php

namespace App\Http\Controllers;

use App\Jobs\EditFileJob;
use App\Jobs\ShellJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UbuntuController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('download')) {
            $path = decrypt($request->query('download'));
            return response()->download($path);
        }
        $files      = File::files('/etc/nginx/sites-available');
        $path       = '/var/www';
        if ($request->query('folder')) {
            $path = decrypt($request->query('folder'));
        }
        $filesWww   = File::files($path, true);
        $foldersWww = File::directories($path, true);
        $isGit = in_array($path . '/.git', $foldersWww);

        $i = 0;
        foreach ($files as $file) {
            File::exists('/etc/nginx/sites-enabled/' . $file->getFilename()) ? $files[$i]->enabled = true : $files[$i]->enabled = false;
            $i++;
        }

        return view('stisla.ubuntu.index', [
            'files'      => $files,
            'filesWww'   => $filesWww,
            'foldersWww' => $foldersWww,
            'path'       => $path,
            'isGit'      => $isGit,
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

        $command = 'cd ' . $pathnameD . ' && git pull origin';
        ShellJob::dispatch($command);

        return redirect()->back()->with('successMessage', 'Berhasil run command git pull origin di ' . $pathnameD);
    }
}
