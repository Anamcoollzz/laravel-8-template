<?php

namespace App\Repositories;

use App\Models\CrudExample;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
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
     * @param mixed $params
     * @return Response
     */
    public function getYajraDataTables($additionalParams = null)
    {
        $query = $this->query()->when(request('order')[0]['column'] == 0, function ($query) {
            $query->latest();
        });
        return DataTables::of($query)
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
            ->editColumn('action', function (CrudExample $crudExample) use ($additionalParams) {
                $isAjaxYajra = Route::is('crud-examples.index-ajax-yajra') || request('isAjaxYajra') == 1;
                $data = array_merge($additionalParams ? $additionalParams : [], [
                    'item'        => $crudExample,
                    'isAjaxYajra' => $isAjaxYajra,
                ]);
                return view('stisla.includes.forms.buttons.btn-action', $data);
            })
            ->rawColumns(['tags', 'file', 'color', 'action'])
            ->make(true);
    }

    /**
     * get yajra columns
     *
     * @return string
     */
    public function getYajraColumns()
    {
        return json_encode([
            [
                'data'       => 'DT_RowIndex',
                'name'       => 'DT_RowIndex',
                'searchable' => false,
                'orderable'  => false
            ],
            ['data' => 'text', 'name' => 'text'],
            ['data' => 'number', 'name' => 'number'],
            ['data' => 'currency', 'name' => 'currency'],
            ['data' => 'currency_idr', 'name' => 'currency_idr'],
            ['data' => 'select', 'name' => 'select'],
            ['data' => 'select2', 'name' => 'select2'],
            ['data' => 'select2_multiple', 'name' => 'select2_multiple'],
            ['data' => 'textarea', 'name' => 'textarea'],
            ['data' => 'radio', 'name' => 'radio'],
            ['data' => 'checkbox', 'name' => 'checkbox'],
            ['data' => 'checkbox2', 'name' => 'checkbox2'],
            ['data' => 'tags', 'name' => 'tags'],
            ['data' => 'file', 'name' => 'file'],
            ['data' => 'date', 'name' => 'date'],
            ['data' => 'time', 'name' => 'time'],
            ['data' => 'color', 'name' => 'color'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'updated_at', 'name' => 'updated_at'],
            [
                'data' => 'action',
                'name' => 'action',
                'orderable' => false,
                'searchable' => false
            ],
        ]);
    }
}
