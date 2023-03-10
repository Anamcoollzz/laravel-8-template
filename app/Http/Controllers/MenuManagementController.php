<?php

namespace App\Http\Controllers;

use App\Exports\MenuExport;
use App\Http\Requests\MenuRequest;
use App\Http\Requests\ImportExcelRequest;
use App\Imports\MenuImport;
use App\Models\Menu;
use App\Repositories\MenuGroupRepository;
use App\Repositories\MenuRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MenuManagementController extends StislaController
{

    /**
     * menu repository
     *
     * @var MenuRepository
     */
    private MenuRepository $menuRepository;

    /**
     * menu group repository
     *
     * @var MenuGroupRepository
     */
    private MenuGroupRepository $menuGroupRepository;

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->icon                = 'fa fa-bars';
        $this->menuRepository      = new MenuRepository;
        $this->menuGroupRepository = new MenuGroupRepository;

        $this->defaultMiddleware('Manajemen Menu');
    }

    /**
     * showing menu page
     *
     * @return Response
     */
    public function index()
    {
        $isYajra = Route::is('yajra-crud-examples.index');
        if ($isYajra) {
            $data = collect([]);
        } else {
            $data = $this->menuRepository->getFullData();
        }

        $defaultData = $this->getDefaultDataIndex(__('Manajemen Menu'), 'Manajemen Menu', 'menu-managements');

        return view('stisla.menu-managements.index', array_merge($defaultData, [
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
        return $this->menuRepository->getYajraDataTables();
    }

    /**
     * showing add new menu page
     *
     * @return Response
     */
    public function create()
    {
        $title         = __('Manajemen Menu');
        $fullTitle     = __('Tambah Menu');
        $groupOptions  = $this->menuGroupRepository->getSelectOptions('group_name', 'id');
        $parentOptions = $this->menuRepository->getSelectOptions('menu_name', 'id');
        $defaultData   = $this->getDefaultDataCreate($title, 'menu-managements');

        $parentOptions[''] = __('Tidak Ada');

        return view('stisla.menu-managements.form', array_merge($defaultData, [
            'fullTitle'     => $fullTitle,
            'groupOptions'  => $groupOptions,
            'parentOptions' => $parentOptions,
        ]));
    }

    /**
     * save new menu to db
     *
     * @param MenuRequest $request
     * @return Response
     */
    public function store(MenuRequest $request)
    {
        $data = $request->only([
            'menu_name',
            'route_name',
            'icon',
            'parent_menu_id',
            'permission',
            'is_active_if_url_includes',
            'is_blank',
            'uri',
            'menu_group_id',
        ]);
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->uploadMenuFile($request->file('file'));
        // }
        // $data['currency'] = str_replace(',', '', $request->currency);
        // $data['currency_idr'] = str_replace('.', '', $request->currency_idr);
        $result = $this->menuRepository->create($data);
        logCreate("Manajemen Menu", $result);
        $successMessage = successMessageCreate("Menu");
        return back()->with('successMessage', $successMessage);
    }

    /**
     * get detail data
     *
     * @param Menu $menuManagement
     * @param bool $isDetail
     * @return array
     */
    private function getDetail(Menu $menuManagement, bool $isDetail = false)
    {
        $title         = __('Manajemen Menu');
        $defaultData   = $this->getDefaultDataDetail($title, 'menu-managements', $menuManagement, $isDetail);
        $groupOptions  = $this->menuGroupRepository->getSelectOptions('group_name', 'id');
        $parentOptions = $this->menuRepository->getSelectOptions('menu_name', 'id');

        $parentOptions[''] = __('Tidak Ada');
        return array_merge($defaultData, [
            'title'         => $title,
            'fullTitle'     => $isDetail ? __('Detail Menu') : __('Ubah Menu'),
            'groupOptions'  => $groupOptions,
            'parentOptions' => $parentOptions,
        ]);
    }

    /**
     * showing edit menu page
     *
     * @param Menu $menuManagement
     * @return Response
     */
    public function edit(Menu $menuManagement)
    {
        $data = $this->getDetail($menuManagement);
        return view('stisla.menu-managements.form', $data);
    }

    /**
     * update data to db
     *
     * @param MenuRequest $request
     * @param Menu $menuManagement
     * @return Response
     */
    public function update(MenuRequest $request, Menu $menuManagement)
    {
        $data = $request->only([
            'menu_name',
            'route_name',
            'icon',
            'parent_menu_id',
            'permission',
            'is_active_if_url_includes',
            'is_blank',
            'uri',
            'menu_group_id',
        ]);
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->uploadMenuFile($request->file('file'));
        // }
        // $data['currency'] = str_replace(',', '', $request->currency);
        // $data['currency_idr'] = str_replace('.', '', $request->currency_idr);
        $newData = $this->menuRepository->update($data, $menuManagement->id);
        logUpdate("Manajemen Menu", $menuManagement, $newData);
        $successMessage = successMessageUpdate("Menu");
        return back()->with('successMessage', $successMessage);
    }

    public function show(Menu $menuManagement)
    {
        $data = $this->getDetail($menuManagement, true);
        return view('stisla.menu-managements.form', $data);
    }

    /**
     * delete menu from db
     *
     * @param Menu $menuManagement
     * @return Response
     */
    public function destroy(Menu $menuManagement)
    {
        // $this->fileService->deleteMenuFile($menuManagement);
        $this->menuRepository->delete($menuManagement->id);
        logDelete("Manajemen Menu", $menuManagement);
        $successMessage = successMessageDelete("Menu");
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

        $excel = new MenuExport($this->menuRepository->getLatest());
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
        $this->fileService->importExcel(new MenuImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("Manajemen Menu");
        return back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->menuRepository->getLatest();
        return $this->fileService->downloadJson($data, 'crud_examples.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data  = $this->menuRepository->getLatest();
        $excel = new MenuExport($data);
        return $this->fileService->downloadExcel($excel, 'crud_examples.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data  = $this->menuRepository->getLatest();
        $excel = new MenuExport($data);
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
            'data'     => $this->menuRepository->getLatest(),
            'isExport' => true
        ];
        // return $this->fileService->downloadPdfLetter('stisla.menu-managements.export-pdf', $data, 'crud_examples.pdf');
        // return $this->fileService->downloadPdfLegal('stisla.menu-managements.export-pdf', $data, 'crud_examples.pdf');
        return $this->fileService->downloadPdfA2('stisla.menu-managements.export-pdf', $data, 'crud_examples.pdf');
    }
}
