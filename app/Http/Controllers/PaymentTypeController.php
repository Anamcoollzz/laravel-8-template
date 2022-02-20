<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentTypeRequest;
use App\Models\PaymentType;
use App\Repositories\PaymentTypeRepository;
use App\Services\FileService;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Helpers\Helper;

class PaymentTypeController extends Controller
{
    /**
     * paymentTypeRepository
     *
     * @var PaymentTypeRepository
     */
    private PaymentTypeRepository $paymentTypeRepository;

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
        $this->paymentTypeRepository = new PaymentTypeRepository;
        $this->fileService = new FileService;
        // $this->middleware('can:Jenis Pembayaran');
        // $this->middleware('can:Jenis Pembayaran Tambah')->only(['create', 'store']);
        // $this->middleware('can:Jenis Pembayaran Ubah')->only(['edit', 'update']);
        // $this->middleware('can:Jenis Pembayaran Hapus')->only(['destroy']);
        // $this->middleware('can:Mahasiswa Impor Excel')->only(['importExcelExample', 'importExcel']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        return view('payment-types.index', [
            'data' => $this->paymentTypeRepository->getLatest(),
        ]);
    }

    /**
     * show add new data page
     *
     * @return Response
     */
    public function create()
    {
        return view('payment-types.form', [

        ]);
    }

    /**
     * save new data to db
     *
     * @param PaymentTypeRequest $request
     * @return Response
     */
    public function store(PaymentTypeRequest $request)
    {
        $this->paymentTypeRepository->create(
            array_merge(
                [

                ],
                $request->only([
                    'type_name', 'bill_amount', 'payment_time_type', 
                ])
            )
        );
        return redirect()->back()->with('successMessage', __('Berhasil menambah data'));
    }

    /**
     * showing edit page
     *
     * @param PaymentType $paymentType
     * @return Response
     */
    public function edit(PaymentType $paymentType)
    {
        return view('payment-types.form', [
            'd' => $paymentType,
        ]);
    }

    /**
     * update data to db
     *
     * @param PaymentTypeRequest $request
     * @param PaymentType $paymentType
     * @return Response
     */
    public function update(PaymentTypeRequest $request, PaymentType $paymentType)
    {
        $this->paymentTypeRepository->update(
            array_merge(
                [

                ],
                $request->only([
                    'type_name', 'bill_amount', 'payment_time_type', 
                ])
            ),
            $paymentType->id
        );
        return redirect()->back()->with('successMessage', __('Berhasil memperbarui data'));
    }

    /**
     * delete from db
     *
     * @param PaymentType $paymentType
     * @return Response
     */
    public function destroy(PaymentType $paymentType)
    {
        $this->paymentTypeRepository->delete($paymentType->id);
        return redirect()->back()->with('successMessage', __('Berhasil menghapus data'));
    }

    /**
     * download import example
     *
     * @return BinaryFileResponse
     */
    public function importExcelExample(): BinaryFileResponse
    {
        return Excel::download(new \App\Exports\PaymentTypeExport(
            $this->paymentTypeRepository->getLatest()
        ), 'payment-types_excel_import_example.xlsx');
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
        Excel::import(new \App\Imports\PaymentTypeImport, $request->file('import_file'));
        return Helper::redirectSuccess(route('payment-typess.index'), __('Impor berhasil dilakukan'));
    }
}
