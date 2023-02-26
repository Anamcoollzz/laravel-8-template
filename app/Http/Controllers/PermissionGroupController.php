<?php

namespace App\Http\Controllers;

use App\Exports\PermissionGroupExport;
use App\Http\Requests\ImportExcelRequest;
use App\Http\Requests\PermissionGroupRequest;
use App\Imports\PermissionGroupImport;
use App\Models\PermissionGroup;
use App\Repositories\UserRepository;
use App\Services\FileService;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PermissionGroupController extends Controller
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

        $this->middleware('can:Group Permission');
        $this->middleware('can:Group Permission Tambah')->only(['create', 'store']);
        $this->middleware('can:Group Permission Ubah')->only(['edit', 'update']);
        $this->middleware('can:Group Permission Hapus')->only(['destroy']);
    }

    /**
     * showing user management page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.user-management.permission-groups.index', [
            'data'                    => $this->userRepository->getLatestPermissionGroups(),
            'canImportExcel'          => $user->can('Group Permission Impor Excel'),
            'canCreate'               => $user->can('Group Permission Tambah'),
            'canUpdate'               => $user->can('Group Permission Ubah'),
            'canDelete'               => $user->can('Group Permission Hapus'),
            'moduleIcon'              => $this->moduleIcon,
            'title'                   => 'Group Permission',
            'routeCreate'             => route('user-management.permission-groups.create'),
            'routeImportExcel'        => route('user-management.permission-groups.import-excel'),
            'routeImportExcelExample' => route('user-management.permission-groups.import-excel-example'),
        ]);
    }

    /**
     * showing create role page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.user-management.permission-groups.form', [
            'permissionGroups' => $this->userRepository->getPermissionGroupWithChild(),
            'action'           => route('user-management.permission-groups.store'),
            'actionType'       => CREATE,
            'title'            => 'Group Permission',
            'fullTitle'        => 'Tambah Group Permission',
            'moduleIcon'       => $this->moduleIcon,
            'routeIndex'       => route('user-management.permission-groups.index'),
        ]);
    }

    /**
     * store permission group data
     *
     * @param PermissionGroupRequest $request
     * @return Response
     */
    public function store(PermissionGroupRequest $request)
    {
        $data = $request->only(['group_name']);
        $result = $this->userRepository->createPermissionGroup($data);
        logCreate('Group Permission', $result);
        $successMessage = successMessageCreate('Group Permission');
        return back()->with('successMessage', $successMessage);
    }

    /**
     * showing edit permission group page
     *
     * @param PermissionGroup $permissionGroup
     * @return Response
     */
    public function edit(PermissionGroup $permissionGroup)
    {
        return view('stisla.user-management.permission-groups.form', [
            'd'                => $permissionGroup,
            'permissionGroups' => $this->userRepository->getPermissionGroupWithChild(),
            'action'           => route('user-management.permission-groups.update', [$permissionGroup->id]),
            'actionType'       => UPDATE,
            'moduleIcon'       => $this->moduleIcon,
            'fullTitle'        => 'Ubah Group Permission',
            'title'            => 'Group Permission',
            'routeIndex'       => route('user-management.permission-groups.index'),
        ]);
    }

    /**
     * update permission group data
     *
     * @param PermissionGroupRequest $request
     * @param PermissionGroup $permissionGroup
     * @return Response
     */
    public function update(PermissionGroupRequest $request, PermissionGroup $permissionGroup)
    {
        $before = $this->userRepository->findPermissionGroup($permissionGroup->id);
        $data = $request->only(['group_name']);
        $after = $this->userRepository->updatePermissionGroup($permissionGroup->id, $data);
        logUpdate('Group Permission', $before, $after);
        $successMessage = successMessageUpdate('Group Permission');
        return back()->with('successMessage', $successMessage);
    }

    /**
     * delete permission data
     *
     * @param Permission $permissionGroup
     * @return Response
     */
    public function destroy(Permission $permissionGroup)
    {
        DB::beginTransaction();
        try {
            $before = $this->userRepository->findPermissionGroup($permissionGroup->id);
            $this->userRepository->deletePermissionGroup($permissionGroup->id);
            logDelete('Group Permission', $before);
            DB::commit();
            $successMessage = successMessageDelete('Group Permission');
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
        $excel = new PermissionGroupExport($this->userRepository->getLatestPermissionGroups());
        return $this->fileService->downloadExcel($excel, 'permission_group_import_examples.xlsx');
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
            $this->fileService->importExcel(new PermissionGroupImport, $request->file('import_file'));
            $successMessage = successMessageImportExcel("Group Permission");
            DB::commit();
            return back()->with('successMessage', $successMessage);
        } catch (Exception $exception) {
            DB::rollBack();
            return back()->with('errorMessage', $exception->getMessage());
        }
    }
}
