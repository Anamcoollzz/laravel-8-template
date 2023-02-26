<?php

namespace App\Imports;

use App\Models\PermissionGroup;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PermissionGroupImport implements ToCollection, WithHeadingRow
{

    /**
     * To collection
     *
     * @return void
     */
    public function collection(Collection $rows)
    {
        $dateTime = date('Y-m-d H:i:s');
        foreach ($rows->chunk(30) as $chunkData) {
            $insertData = $chunkData->transform(function ($item) use ($dateTime) {
                $item->put('created_at', $dateTime);
                $item->put('updated_at', $dateTime);
                $item->put('group_name', $item['group']);
                $item->forget('group');
                $item->forget('');
                return $item;
            })->toArray();
            PermissionGroup::insert($insertData);
        }
    }
}
