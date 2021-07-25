<?php

namespace App\Exports;

use App\Models\CrudExample;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CrudExampleExport implements FromView
{
    /**
     * data
     *
     * @var Collection
     */
    private Collection $data;

    /**
     * constructor method
     *
     * @param Collection $data
     * @return void
     */
    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    /**
     * export from view
     *
     * @return View
     */
    public function view(): View
    {
        return view('crud-example.export-excel-example', [
            'data'       => $this->data,
            'isExport' => true
        ]);
    }
}
