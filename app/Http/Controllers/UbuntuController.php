<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UbuntuController extends Controller
{
    public function index()
    {
        $files = File::allFiles('/etc/nginx/sites-available');
        dd($files);
        return view('stisla.ubuntu.index');
    }
}
