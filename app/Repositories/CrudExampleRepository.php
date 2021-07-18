<?php

namespace App\Repositories;

use App\Models\CrudExample;

class CrudExampleRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new CrudExample();
    }
}
