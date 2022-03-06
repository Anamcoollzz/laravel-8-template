<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Models\MenuGroup;
use Illuminate\Database\Eloquent\Collection;

class MenuRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Menu();
    }

    /**
     * getMenus
     *
     * @return Collection
     */
    public function getMenus()
    {
        $results = MenuGroup::query()
            ->with(['menus'])
            ->get();
        return $results;
    }
}
