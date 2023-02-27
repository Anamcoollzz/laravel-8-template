<?php

namespace App\Repositories;

use App\Models\CrudExample;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

class CrudExampleRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new CrudExample();
    }

    /**
     * get data for yajra datatables
     *
     * @return Response
     */
    public function getYajraDataTables()
    {
        return DataTables::of($this->query())
            ->addIndexColumn()
            ->editColumn('currency', '{{dollar($currency)}}')
            ->editColumn('currency_idr', '{{rp($currency_idr)}}')
            ->editColumn('select2_multiple', '{{implode(", ", $select2_multiple)}}')
            ->editColumn('checkbox', '{{implode(", ", $checkbox)}}')
            ->editColumn('checkbox2', '{{implode(", ", $checkbox2)}}')
            ->editColumn('tags', 'stisla.crud-example.tags')
            ->editColumn('file', 'stisla.crud-example.file')
            ->editColumn('color', 'stisla.crud-example.color')
            ->editColumn('created_at', '{{\Carbon\Carbon::parse($created_at)->addHour(7)->format("Y-m-d H:i:s")}}')
            ->editColumn('updated_at', '{{\Carbon\Carbon::parse($updated_at)->addHour(7)->format("Y-m-d H:i:s")}}')
            ->editColumn('action', function (CrudExample $crudExample) {
                $user = auth()->user();
                return view('stisla.crud-example.action', [
                    'canUpdate' => $user->can('Contoh CRUD Ubah'),
                    'canDetail' => $user->can('Contoh CRUD Detail'),
                    'canDelete' => $user->can('Contoh CRUD Hapus'),
                    'item'      => $crudExample,
                ]);
            })
            ->rawColumns(['tags', 'file', 'color', 'action'])
            ->make(true);
    }
}
