<?php

namespace App\Http\Controllers;

use App\Exports\PermissionExport;
use App\Http\Requests\ImportExcelRequest;
use App\Http\Requests\PermissionRequest;
use App\Imports\PermissionImport;
use App\Repositories\UserRepository;
use App\Services\FileService;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PermissionController extends Controller
{
    /**
     * user repository
     *
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * file service
     *
     * @var FileService
     */
    private FileService $fileService;

    /**
     * icon module
     *
     * @var string
     */
    private string $moduleIcon = 'fa fa-user-lock';

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->userRepository = new UserRepository;
        $this->fileService    = new FileService;

        $this->middleware('can:Permission');
        $this->middleware('can:Permission Tambah')->only(['create', 'store']);
        $this->middleware('can:Permission Ubah')->only(['edit', 'update']);
        $this->middleware('can:Permission Hapus')->only(['destroy']);
    }

    /**
     * showing user management page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.user-management.permissions.index', [
            'data'                    => $this->userRepository->getLatestPermissionJoinGroups(),
            'canImportExcel'          => $user->can('Permission Impor Excel'),
            'canCreate'               => $user->can('Permission Tambah'),
            'canUpdate'               => $user->can('Permission Ubah'),
            'canDelete'               => $user->can('Permission Hapus'),
            'moduleIcon'              => $this->moduleIcon,
            'title'                   => 'Permission',
            'routeCreate'             => route('user-management.permissions.create'),
            'routeImportExcel'        => route('user-management.permissions.import-excel'),
            'routeImportExcelExample' => route('user-management.permissions.import-excel-example'),
        ]);
    }

    /**
     * showing create role page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.user-management.permissions.form', [
            'permissionGroups' => $this->userRepository->getPermissionGroupWithChild(),
            'action'           => route('user-management.permissions.store'),
            'actionType'       => CREATE,
            'title'            => 'Permission',
            'fullTitle'        => 'Tambah Permission',
            'moduleIcon'       => $this->moduleIcon,
            'groupOptions'     => $this->userRepository->getPermissionGroupOptions(),
            'routeIndex'       => route('user-management.permissions.index'),
        ]);
    }

    /**
     * store role data
     *
     * @param PermissionRequest $request
     * @return Response
     */
    public function store(PermissionRequest $request)
    {
        $data = $request->only(['name', 'permission_group_id']);
        $result = $this->userRepository->createPermission($data);
        logCreate('Permission', $result);
        $successMessage = successMessageCreate('Permission');
        return back()->with('successMessage', $successMessage);
    }

    /**
     * showing edit permission page
     *
     * @param Permission $permission
     * @return Response
     */
    public function edit(Permission $permission)
    {
        return view('stisla.user-management.permissions.form', [
            'd'                => $permission,
            'permissionGroups' => $this->userRepository->getPermissionGroupWithChild(),
            'action'           => route('user-management.permissions.update', [$permission->id]),
            'actionType'       => UPDATE,
            'moduleIcon'       => $this->moduleIcon,
            'fullTitle'        => 'Ubah Permission',
            'title'            => 'Permission',
            'groupOptions'     => $this->userRepository->getPermissionGroupOptions(),
            'routeIndex'       => route('user-management.permissions.index'),
        ]);
    }

    /**
     * update permission data
     *
     * @param PermissionRequest $request
     * @param Permission $permission
     * @return Response
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        $before = $this->userRepository->findPermission($permission->id);
        $data = $request->only(['name', 'permission_group_id',]);
        $after = $this->userRepository->updatePermission($permission->id, $data);
        logUpdate('Permission', $before, $after);
        $successMessage = successMessageUpdate('Permission');
        return back()->with('successMessage', $successMessage);
    }

    /**
     * delete permission data
     *
     * @param Permission $permission
     * @return Response
     */
    public function destroy(Permission $permission)
    {
        DB::beginTransaction();
        try {
            $before = $this->userRepository->findPermission($permission->id);
            $this->userRepository->deletePermission($permission->id);
            logDelete('Permission', $before);
            DB::commit();
            $successMessage = successMessageDelete('Permission');
            return back()->with('successMessage', $successMessage);
        } catch (Exception $exception) {
            DB::rollBack();
            return back()->with('errorMessage', $exception->getMessage());
        }
    }

    /**
     * download import example
     *
     * @return BinaryFileResponse
     */
    public function importExcelExample(): BinaryFileResponse
    {
        $excel = new PermissionExport($this->userRepository->getLatestPermissionJoinGroups());
        return $this->fileService->downloadExcel($excel, 'permission_import_examples.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(ImportExcelRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->fileService->importExcel(new PermissionImport, $request->file('import_file'));
            $successMessage = successMessageImportExcel("Permission");
            DB::commit();
            return back()->with('successMessage', $successMessage);
        } catch (Exception $exception) {
            DB::rollBack();
            return back()->with('errorMessage', $exception->getMessage());
        }
    }
}
