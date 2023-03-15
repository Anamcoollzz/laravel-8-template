<?php

namespace App\Repositories;

use App\Models\PermissionGroup;

class PermissionGroupRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new PermissionGroup();
    }
}
