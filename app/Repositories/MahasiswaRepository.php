<?php

namespace App\Repositories;

use App\Models\Mahasiswa;

class MahasiswaRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Mahasiswa();
    }
}
