<?php

namespace App\Repositories;

use App\Models\MenuGroup;

class MenuGroupRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new MenuGroup();
    }
}
