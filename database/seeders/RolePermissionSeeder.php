<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Role::truncate();
        $roles = json_decode(file_get_contents(database_path('seeders/data/roles.json')), true);
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        Permission::truncate();
        $permissions = json_decode(file_get_contents(database_path('seeders/data/permissions.json')), true);
        foreach ($permissions as $permission) {
            $group = PermissionGroup::updateOrCreate([
                'group_name' => $permission['group']
            ]);
            $perm = Permission::create([
                'name' => $permission['name'],
                'permission_group_id' => $group->id
            ]);
            foreach ($permission['roles'] as $role)
                $perm->assignRole($role);
        }
    }
}
