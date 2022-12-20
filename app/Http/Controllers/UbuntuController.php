<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UbuntuController extends Controller
{
    public function index()
    {
        $files = File::allFiles('/etc/nginx/sites-available');
        $files2 = File::allFiles('/etc/nginx/sites-enabled');
        dd($files);
        return view('stisla.ubuntu.index', [
            'files' => $files,
        ]);
    }
}
