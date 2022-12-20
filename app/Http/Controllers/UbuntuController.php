<?php

namespace App\Http\Controllers;

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
        $pathname = decrypt($pathname);
        $view = file_get_contents($pathname);
        dd($view);
        return view('stisla.crud-example.form', [
            'd'             => $crudExample,
            'title'         => __('Contoh CRUD'),
            'fullTitle'     => __('Ubah Contoh CRUD'),
            'routeIndex'    => route('crud-examples.index'),
            'action'        => route('crud-examples.update', [$crudExample->id])
        ]);
    }
}
