<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function datatable()
    {
        return view('testing.datatable');
    }
}
