<?php

namespace App\Imports;

use App\Models\PermissionGroup;
use App\Repositories\PermissionGroupRepository;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PermissionGroupImport implements ToCollection, WithHeadingRow
{

    /**
     * permission group repository
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
            $this->permissionGroupRepository->create([
                'group_name' => $row['group']
            ]);
        }
    }
}
