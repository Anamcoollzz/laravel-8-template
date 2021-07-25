<?php

namespace App\Http\Controllers;

use App\Http\Requests\MahasiswaRequest;
use App\Models\Mahasiswa;
use App\Repositories\MahasiswaRepository;
use App\Services\FileService;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Helpers\Helper;

class MahasiswaController extends Controller
{
    /**
     * mahasiswaRepository
     *
     * @var MahasiswaRepository
     */
    private MahasiswaRepository $mahasiswaRepository;

    /**
     * fileService
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
        $this->mahasiswaRepository = new MahasiswaRepository;
        $this->fileService = new FileService;
        // $this->middleware('can:Mahasiswa');
        // $this->middleware('can:Mahasiswa Tambah')->only(['create', 'store']);
        // $this->middleware('can:Mahasiswa Ubah')->only(['edit', 'update']);
        // $this->middleware('can:Mahasiswa Hapus')->only(['destroy']);
        // $this->middleware('can:Mahasiswa Impor Excel')->only(['importExcelExample', 'importExcel']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        return view('mahasiswa.index', [
            'data' => $this->mahasiswaRepository->getLatest(),
        ]);
    }

    /**
     * show add new data page
     *
     * @return Response
     */
    public function create()
    {
        return view('mahasiswa.form', [

        ]);
    }

    /**
     * save new data to db
     *
     * @param MahasiswaRequest $request
     * @return Response
     */
    public function store(MahasiswaRequest $request)
    {
        $this->mahasiswaRepository->create(
            array_merge(
                [

                ],
                $request->only([
                    'name', 'birth_date', 'select2', 'select', 'colorpicker', 'number', 'image', 'file', 'password', 'email', 'time', 'address', 'gender', 
                ])
            )
        );
        return redirect()->back()->with('successMessage', __('Berhasil menambah data'));
    }

    /**
     * showing edit page
     *
     * @param Mahasiswa $mahasiswa
     * @return Response
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.form', [
            'd' => $mahasiswa,
        ]);
    }

    /**
     * update data to db
     *
     * @param MahasiswaRequest $request
     * @param Mahasiswa $mahasiswa
     * @return Response
     */
    public function update(MahasiswaRequest $request, Mahasiswa $mahasiswa)
    {
        $this->mahasiswaRepository->update(
            array_merge(
                [

                ],
                $request->only([
                    'name', 'birth_date', 'select2', 'select', 'colorpicker', 'number', 'image', 'file', 'password', 'email', 'time', 'address', 'gender', 
                ])
            ),
            $mahasiswa->id
        );
        return redirect()->back()->with('successMessage', __('Berhasil memperbarui data'));
    }

    /**
     * delete from db
     *
     * @param Mahasiswa $mahasiswa
     * @return Response
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $this->mahasiswaRepository->delete($mahasiswa->id);
        return redirect()->back()->with('successMessage', __('Berhasil menghapus data'));
    }

    /**
     * download import example
     *
     * @return BinaryFileResponse
     */
    public function importExcelExample(): BinaryFileResponse
    {
        return Excel::download(new \App\Exports\MahasiswaExport(
            $this->mahasiswaRepository->getLatest()
        ), 'mahasiswa_excel_import_example.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function importExcel(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
        Excel::import(new \App\Imports\MahasiswaImport, $request->file('import_file'));
        return Helper::redirectSuccess(route('mahasiswas.index'), __('Impor berhasil dilakukan'));
    }
}
