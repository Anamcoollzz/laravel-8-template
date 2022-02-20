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
        return view('stisla.dashboard.index', [
            'widgets' => [
                [
                    'name' => 'Siswa',
                    'bg' => 'danger',
                    'count' => '3.600',
                    'icon' => 'users'
                ],
                [
                    'name' => 'Siswa Aktif',
                    'bg' => 'danger',
                    'count' => '3.400',
                    'icon' => 'users'
                ],
                [
                    'name' => 'Siswa Aktif Laki-laki',
                    'bg' => 'danger',
                    'count' => '2.400',
                    'icon' => 'users'
                ],
                [
                    'name' => 'Siswa Aktif Perempuan',
                    'bg' => 'danger',
                    'count' => '1.000',
                    'icon' => 'users'
                ],
                [
                    'name' => 'Siswa Alumni',
                    'bg' => 'danger',
                    'count' => 200,
                    'icon' => 'users'
                ],
            ],
            'widgets3' => [
                [
                    'name' => 'Kelas',
                    'bg' => 'primary',
                    'count' => 3,
                    'icon' => 'chair'
                ],
                [
                    'name' => 'Grup Kelas',
                    'bg' => 'primary',
                    'count' => 3,
                    'icon' => 'university'
                ],
                [
                    'name' => 'Tahun Ajaran',
                    'bg' => 'primary',
                    'count' => 3,
                    'icon' => 'calendar'
                ],
                [
                    'name' => 'Jenis Pembayaran',
                    'bg' => 'primary',
                    'count' => 11,
                    'icon' => 'certificate'
                ],
                [
                    'name' => 'Pengguna Operator',
                    'bg' => 'primary',
                    'count' => 5,
                    'icon' => 'user-plus'
                ],
            ],
            'widgets2' => [
                [
                    'name' => 'Transaksi Direkam',
                    'bg' => 'success',
                    'count' => '20.400',
                    'icon' => 'history'
                ],
                [
                    'name' => 'Uang Masuk',
                    'bg' => 'success',
                    'count' => 'Rp2.300.000.000',
                    'icon' => 'dollar-sign'
                ],
                [
                    'name' => 'Tanggungan Belum Terbayar',
                    'bg' => 'success',
                    'count' => 'Rp1.200.000.000',
                    'icon' => 'dollar-sign'
                ],
                [
                    'name' => 'Uang Masuk Hari Ini',
                    'bg' => 'success',
                    'count' => 'Rp1.100.000',
                    'icon' => 'dollar-sign'
                ],
                [
                    'name' => 'Uang Masuk Bulan Ini',
                    'bg' => 'success',
                    'count' => 'Rp30.500.000',
                    'icon' => 'dollar-sign'
                ],
                [
                    'name' => 'Uang Masuk Tahun Ini',
                    'bg' => 'success',
                    'count' => 'Rp100.600.000',
                    'icon' => 'dollar-sign'
                ]
            ]
        ]);
    }
}
