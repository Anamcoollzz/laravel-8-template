<?php

namespace App\Http\Controllers;

use App\Jobs\EditFileJob;
use App\Jobs\ShellJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UbuntuController extends Controller
{
    public function index()
    {
        $files  = File::allFiles('/etc/nginx/sites-available');

        $i = 0;
        foreach ($files as $file) {
            File::exists('/etc/nginx/sites-enabled/' . $file->getFilename()) ? $files[$i]->enabled = true : $files[$i]->enabled = false;
            $i++;
        }

        return view('stisla.ubuntu.index', [
            'files' => $files,
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
            $command = 'ln -s ' . $pathname . ' /etc/nginx/sites-enabled/';
            dd($command);
            ShellJob::dispatch($command);
        } else if ($nextStatus === 'false') {
            $paths = explode('/', $pathnameD);
            $command = 'rm /etc/nginx/sites-enabled/' . end($paths);
            ShellJob::dispatch($command);
        }

        return redirect()->back()->with('successMessage', 'Berhasil menset enabled ke ' . $nextStatus);
    }
}