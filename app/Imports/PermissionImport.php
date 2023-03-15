<?php

namespace App\Imports;

use App\Repositories\PermissionGroupRepository;
use App\Repositories\PermissionRepository;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Spatie\Permission\Models\Permission;

class PermissionImport implements ToCollection, WithHeadingRow
{

    /**
     * Permission repository
     *
     * @var PermissionRepository
     */
    private PermissionRepository $permissionRepository;

    /**
     * Permission group repository
     *
     * @var PermissionGroupRepository
     */
    private PermissionGroupRepository $permissionGroupRepository;

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->permissionRepository      = new PermissionRepository();
        $this->permissionGroupRepository = new PermissionGroupRepository();
    }

    /**
     * To collection
     *
     * @return void
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $groupId = $this->permissionGroupRepository->firstOrCreate(['group_name' => $row['group']])->id;
            $this->permissionRepository->createPermission($row['permission'], $groupId);
        }
    }
}
