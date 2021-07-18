<?php

namespace App\Repositories;

use App\Models\ModelName;

class NameRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new ModelName();
    }
}
