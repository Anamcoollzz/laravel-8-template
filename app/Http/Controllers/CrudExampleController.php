<?php

namespace App\Http\Controllers;

use App\Exports\CrudExampleExport;
use App\Helpers\Helper;
use App\Http\Requests\CrudExampleRequest;
use App\Imports\CrudExampleImport;
use App\Models\CrudExample;
use App\Repositories\CrudExampleRepository;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CrudExampleController extends Controller
{
    /**
     * user repository
     *
     * @var CrudExampleRepository
     */
    private CrudExampleRepository $crudExampleRepository;

    /**
     * file service
     *
     * @var FileService
     */
    private FileService $fileService;

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->crudExampleRepository = new CrudExampleRepository;
        $this->fileService = new FileService;
        // $this->middleware('can:Contoh CRUD');
        // $this->middleware('can:Contoh CRUD Tambah')->only(['create', 'store']);
        // $this->middleware('can:Contoh CRUD Ubah')->only(['edit', 'update']);
        // $this->middleware('can:Contoh CRUD Hapus')->only(['destroy']);
    }

    /**
     * showing user management page
     *
     * @return Response
     */
    public function index()
    {
        return view('stisla.crud-example.index', [
            'data' => $this->crudExampleRepository->getLatest(),
        ]);
    }

    /**
     * showing add new user page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.crud-example.form', [
            'selectOptions' => ['option 1' => 'option 1', 'option 2' => 'option 2', 'option 3' => 'option 3',]
        ]);
    }

    /**
     * save new user to db
     *
     * @param CrudExampleRequest $request
     * @return Response
     */
    public function store(CrudExampleRequest $request)
    {
        $this->crudExampleRepository->create(
            array_merge(
                [
                    'file' => $this->fileService->uploadCrudExampleFile($request->file('file')),
                    // 'checkbox' => json_encode($request->chekbox)
                ],
                $request->only([
                    'text',
                    "number",
                    "select",
                    "textarea",
                    "radio",
                    "date",
                    'checkbox',
                    "time",
                    "color",
                    'select2',
                    'select2_multiple'
                ])
            )
        );
        return redirect()->back()->with('successMessage', __('Berhasil menambah data'));
    }

    /**
     * showing edit page
     *
     * @param CrudExample $crudExample
     * @return Response
     */
    public function edit(CrudExample $crudExample)
    {
        return view('stisla.crud-example.form', [
            'selectOptions' => ['option 1' => 'option 1', 'option 2' => 'option 2', 'option 3' => 'option 3',],
            'd'             => $crudExample,
        ]);
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
        $this->crudExampleRepository->update(
            array_merge(
                [
                    'file' => $request->hasFile('file') ? $this->fileService->uploadCrudExampleFile($request->file('file')) : $crudExample->file,
                ],
                $request->only([
                    'text',
                    "number",
                    "select",
                    "textarea",
                    "radio",
                    "date",
                    'checkbox',
                    "time",
                    "color",
                    'select2',
                    'select2_multiple'
                ])
            ),
            $crudExample->id
        );
        return redirect()->back()->with('successMessage', __('Berhasil memperbarui data'));
    }

    /**
     * delete user from db
     *
     * @param CrudExample $crudExample
     * @return Response
     */
    public function destroy(CrudExample $crudExample)
    {
        $this->fileService->deleteCrudExampleFile($crudExample);
        $this->crudExampleRepository->delete($crudExample->id);
        return redirect()->back()->with('successMessage', __('Berhasil menghapus data'));
    }

    /**
     * download import example
     *
     * @return BinaryFileResponse
     */
    public function importExcelExample(): BinaryFileResponse
    {
        return Excel::download(new CrudExampleExport(
            $this->crudExampleRepository->getLatest()
        ), 'crud_examples.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param Request $request
     * @return Response
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
        $data = Excel::import(new CrudExampleImport, $request->file('import_file'));
        return Helper::redirectSuccess(route('crud-examples.index'), __('Impor berhasil dilakukan'));
    }
}
