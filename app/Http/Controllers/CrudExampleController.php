<?php

namespace App\Http\Controllers;

use App\Exports\CrudExampleExport;
use App\Http\Requests\CrudExampleRequest;
use App\Http\Requests\ImportExcelRequest;
use App\Imports\CrudExampleImport;
use App\Models\CrudExample;
use App\Repositories\CrudExampleRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CrudExampleController extends StislaController
{

    /**
     * crud example repository
     *
     * @var CrudExampleRepository
     */
    private CrudExampleRepository $crudExampleRepository;

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->icon                  = 'fa fa-atom';
        $this->crudExampleRepository = new CrudExampleRepository;

        $this->defaultMiddleware('Contoh CRUD');
    }

    /**
     * showing crud example page
     *
     * @return Response
     */
    public function index()
    {
        $isYajra = Route::is('yajra-crud-examples.index');
        if ($isYajra) {
            $data = collect([]);
        } else {
            $data = $this->crudExampleRepository->getLatest();
        }

        $defaultData = $this->getDefaultDataIndex(__('Contoh CRUD'), 'Contoh CRUD', 'crud-examples');

        return view('stisla.crud-example.index', array_merge($defaultData, [
            'data'    => $data,
            'isYajra' => $isYajra,
        ]));
    }

    /**
     * datatable yajra index
     *
     * @return Response
     */
    public function yajraAjax()
    {
        return $this->crudExampleRepository->getYajraDataTables();
    }

    /**
     * showing add new crud example page
     *
     * @return Response
     */
    public function create()
    {
        $title      = __('Contoh CRUD');
        $fullTitle  = __('Tambah Contoh CRUD');
        $data       = $this->getDefaultDataCreate($title, 'crud-examples');
        return view('stisla.crud-example.form', array_merge($data, [
            'selectOptions'   => get_options(10),
            'radioOptions'    => get_options(4),
            'checkboxOptions' => get_options(5),
            'fullTitle'       => $fullTitle,
        ]));
    }

    /**
     * save new crud example to db
     *
     * @param CrudExampleRequest $request
     * @return Response
     */
    public function store(CrudExampleRequest $request)
    {
        $data = $request->only([
            'text',
            "number",
            "select",
            "textarea",
            "radio",
            "date",
            'checkbox',
            'checkbox2',
            "time",
            'tags',
            "color",
            'select2',
            'select2_multiple',
            'summernote',
            'summernote_simple',
        ]);
        if ($request->hasFile('file')) {
            $data['file'] = $this->fileService->uploadCrudExampleFile($request->file('file'));
        }
        $data['currency'] = str_replace(',', '', $request->currency);
        $data['currency_idr'] = str_replace('.', '', $request->currency_idr);
        $result = $this->crudExampleRepository->create($data);
        logCreate("Contoh CRUD", $result);
        $successMessage = successMessageCreate("Contoh CRUD");
        return back()->with('successMessage', $successMessage);
    }

    /**
     * get detail data
     *
     * @param CrudExample $crudExample
     * @param bool $isDetail
     * @return array
     */
    private function getDetail(CrudExample $crudExample, bool $isDetail = false)
    {
        $title       = __('Contoh CRUD');
        $defaultData = $this->getDefaultDataDetail($title, 'crud-examples', $crudExample, $isDetail);
        return array_merge($defaultData, [
            'selectOptions'   => get_options(10),
            'radioOptions'    => get_options(4),
            'checkboxOptions' => get_options(5),
            'fullTitle'       => $isDetail ? __('Detail Contoh CRUD') : __('Ubah Contoh CRUD'),
        ]);
    }

    /**
     * showing edit crud example page
     *
     * @param CrudExample $crudExample
     * @return Response
     */
    public function edit(CrudExample $crudExample)
    {
        $data = $this->getDetail($crudExample);
        return view('stisla.crud-example.form', $data);
    }

    /**
     * update data to db
     *
     * @param CrudExampleRequest $request
     * @param CrudExample $crudExample
     * @return Response
     */
    public function update(CrudExampleRequest $request, CrudExample $crudExample)
    {
        $data = $request->only([
            'text',
            "number",
            "select",
            "textarea",
            "radio",
            "date",
            'checkbox',
            'checkbox2',
            'tags',
            "time",
            "color",
            'select2',
            'select2_multiple',
            'summernote',
            'summernote_simple',
        ]);
        if ($request->hasFile('file')) {
            $data['file'] = $this->fileService->uploadCrudExampleFile($request->file('file'));
        }
        $data['currency'] = str_replace(',', '', $request->currency);
        $data['currency_idr'] = str_replace('.', '', $request->currency_idr);
        $newData = $this->crudExampleRepository->update($data, $crudExample->id);
        logUpdate("Contoh CRUD", $crudExample, $newData);
        $successMessage = successMessageUpdate("Contoh CRUD");
        return back()->with('successMessage', $successMessage);
    }

    public function show(CrudExample $crudExample)
    {
        $data = $this->getDetail($crudExample, true);
        return view('stisla.crud-example.form', $data);
    }

    /**
     * delete crud example from db
     *
     * @param CrudExample $crudExample
     * @return Response
     */
    public function destroy(CrudExample $crudExample)
    {
        $this->fileService->deleteCrudExampleFile($crudExample);
        $this->crudExampleRepository->delete($crudExample->id);
        logDelete("Contoh CRUD", $crudExample);
        $successMessage = successMessageDelete("Contoh CRUD");
        return back()->with('successMessage', $successMessage);
    }

    /**
     * download import example
     *
     * @return BinaryFileResponse
     */
    public function importExcelExample(): BinaryFileResponse
    {
        // bisa gunakan file excel langsung sebagai contoh
        // $filepath = public_path('example.xlsx');
        // return response()->download($filepath);

        $excel = new CrudExampleExport($this->crudExampleRepository->getLatest());
        return $this->fileService->downloadExcel($excel, 'crud_examples_import.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(ImportExcelRequest $request)
    {
        $this->fileService->importExcel(new CrudExampleImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("Contoh CRUD");
        return back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->crudExampleRepository->getLatest();
        return $this->fileService->downloadJson($data, 'crud_examples.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data  = $this->crudExampleRepository->getLatest();
        $excel = new CrudExampleExport($data);
        return $this->fileService->downloadExcel($excel, 'crud_examples.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data  = $this->crudExampleRepository->getLatest();
        $excel = new CrudExampleExport($data);
        return $this->fileService->downloadExcel($excel, 'crud_examples.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf(): Response
    {
        $data = [
            'data'     => $this->crudExampleRepository->getLatest(),
            'isExport' => true
        ];
        // return $this->fileService->downloadPdfLetter('stisla.crud-example.export-pdf', $data, 'crud_examples.pdf');
        // return $this->fileService->downloadPdfLegal('stisla.crud-example.export-pdf', $data, 'crud_examples.pdf');
        return $this->fileService->downloadPdfA2('stisla.crud-example.export-pdf', $data, 'crud_examples.pdf');
    }
}
