<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Permission();
    }

    /**
     * create permission
     *
     * @param string $name
     * @param int $permissionGroupId
     * @param string $guardName
     * @return void
     */
    public function createPermission($name, $permissionGroupId, $guardName = 'web')
    {
        DB::table('permissions')->insert([
            'name'                => $name,
            'permission_group_id' => $permissionGroupId,
            'guard_name'          => $guardName,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);
    }
}
