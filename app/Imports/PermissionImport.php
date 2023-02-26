<?php

namespace App\Imports;

use App\Models\PermissionGroup;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Spatie\Permission\Models\Permission;

class PermissionImport implements ToCollection, WithHeadingRow
{

    /**
     * To collection
     *
     * @return void
     */
    public function collection(Collection $rows)
    {
        $dateTime = date('Y-m-d H:i:s');
        $groups = PermissionGroup::all()->pluck('group_name', 'id')->toArray();
        foreach ($rows->chunk(30) as $chunkData) {
            $insertData = $chunkData->transform(function ($item) use ($dateTime, $groups) {
                $item->put('created_at', $dateTime);
                $item->put('updated_at', $dateTime);
                $item->put('guard_name', 'web');
                $item->put('name', $item['permission']);
                $item->put('permission_group_id', array_search($item['group'], $groups));
                $item->forget('permission');
                $item->forget('group');
                $item->forget('');
                return $item;
            })->toArray();
            Permission::insert($insertData);
        }
    }
}
