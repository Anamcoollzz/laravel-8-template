<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{

    /**
     * Menampilkan halaman dashboard
     *
     * @return Response
     */
    public function index()
    {
        return view('stisla.dashboard.index');
    }
}
