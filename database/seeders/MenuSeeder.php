<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        MenuGroup::truncate();
        Menu::truncate();
        $data = json_decode(file_get_contents(database_path('seeders/data/menus.json')), true);
        foreach ($data as $item) {
            $group = MenuGroup::create([
                'group_name' => $item['group_name']
            ]);
            foreach ($item['menus'] as $menu) {
                $menuObj = Menu::create([
                    'menu_name'                 => $menu['menu_name'],
                    'icon'                      => $menu['icon'],
                    'route_name'                => $menu['route_name'],
                    'permission'                => $menu['permission'],
                    'menu_group_id'             => $group->id,
                    'is_active_if_url_includes' => $menu['is_active_if_url_includes'],
                ]);
                foreach ($menu['childs'] ?? [] as $child) {
                    Menu::create([
                        'menu_name'                 => $child['menu_name'],
                        'icon'                      => $child['icon'],
                        'route_name'                => $child['route_name'],
                        'permission'                => $child['permission'],
                        'parent_menu_id'            => $menuObj->id,
                        'is_active_if_url_includes' => $child['is_active_if_url_includes'],
                    ]);
                }
            }
        }
    }
}
