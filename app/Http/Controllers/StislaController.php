<?php

namespace App\Http\Controllers;

use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Database\Eloquent\Model;

class StislaController extends Controller
{
    /**
     * file service
     *
     * @var FileService
     */
    protected FileService $fileService;

    /**
     * email service
     *
     * @var FileService
     */
    protected EmailService $emailService;

    /**
     * icon of module
     *
     * @var String
     */
    protected String $icon;

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->fileService  = new FileService;
        $this->emailService = new EmailService;
    }

    /**
     * Default middleware
     *
     * @param string $moduleName
     * @return void
     */
    public function defaultMiddleware(string $moduleName)
    {
        $this->middleware('can:' . $moduleName . '');
        $this->middleware('can:' . $moduleName . ' Tambah')->only(['create', 'store']);
        $this->middleware('can:' . $moduleName . ' Ubah')->only(['edit', 'update']);
        $this->middleware('can:' . $moduleName . ' Detail')->only(['show']);
        $this->middleware('can:' . $moduleName . ' Hapus')->only(['destroy']);
        $this->middleware('can:' . $moduleName . ' Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:' . $moduleName . ' Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * Default data index
     *
     * @param string $title
     * @param string $permissionPrefix
     * @param string $routePrefix
     * @return array
     */
    public function getDefaultDataIndex(string $title, string $permissionPrefix, string $routePrefix)
    {
        $user = auth()->user();

        $canCreate      = $user->can($permissionPrefix . ' Tambah');
        $canUpdate      = $user->can($permissionPrefix . ' Ubah');
        $canDetail      = $user->can($permissionPrefix . ' Detail');
        $canDelete      = $user->can($permissionPrefix . ' Hapus');
        $canImportExcel = $user->can($permissionPrefix . ' Impor Excel');
        $canExport      = $user->can($permissionPrefix . ' Ekspor');

        return [
            'canCreate'         => $canCreate,
            'canUpdate'         => $canUpdate,
            'canDetail'         => $canDetail,
            'canDelete'         => $canDelete,
            'canImportExcel'    => $canImportExcel,
            'canExport'         => $canExport,
            'title'             => $title,
            'moduleIcon'        => $this->icon,
            'route_create'      => $canCreate ? route($routePrefix . '.create') : null,
            'routeImportExcel'  => $canImportExcel ? route($routePrefix . '.import-excel') : null,
            'routeExampleExcel' => $canImportExcel ? route($routePrefix . '.import-excel-example') : null,
            'routePdf'          => $canExport ? route($routePrefix . '.pdf') : null,
            'routeExcel'        => $canExport ? route($routePrefix . '.excel') : null,
            'routeCsv'          => $canExport ? route($routePrefix . '.csv') : null,
            'routeJson'         => $canExport ? route($routePrefix . '.json') : null,
            'routeYajra'        => route($routePrefix . '.ajax-yajra'),
        ];
    }

    /**
     * Default data create
     *
     * @param string $title
     * @param string $prefixRoute
     * @return array
     */
    public function getDefaultDataCreate(string $title, string $prefixRoute)
    {
        $routeIndex = route($prefixRoute . '.index');
        return [
            'title'           => $title,
            'routeIndex'      => $routeIndex,
            'action'          => route($prefixRoute . '.store'),
            'moduleIcon'      => $this->icon,
            'isDetail'        => false,
            'breadcrumbs'     => [
                [
                    'label' => __('Dashboard'),
                    'link'  => route('dashboard.index')
                ],
                [
                    'label' => $title,
                    'link'  => $routeIndex
                ],
                [
                    'label' => 'Tambah'
                ]
            ]
        ];
    }

    /**
     * Default data detail
     *
     * @param string $title
     * @param string $prefixRoute
     * @param Model $row
     * @param boolean $isDetail
     * @return array
     */
    public function getDefaultDataDetail(string $title, string $prefixRoute, Model $row, bool $isDetail)
    {
        $routeIndex  = route($prefixRoute . '.index');
        $breadcrumbs = [
            [
                'label' => __('Dashboard'),
                'link'  => route('dashboard.index')
            ],
            [
                'label' => $title,
                'link'  => $routeIndex
            ],
            [
                'label' => $isDetail ? 'Detail' : 'Ubah'
            ]
        ];
        return [
            'd'               => $row,
            'title'           => $title,
            'routeIndex'      => $routeIndex,
            'action'          => route($prefixRoute . '.update', [$row->id]),
            'moduleIcon'      => $this->icon,
            'isDetail'        => $isDetail,
            'breadcrumbs'     => $breadcrumbs,
        ];
    }
}
