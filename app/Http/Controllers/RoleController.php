<?php

namespace App\Http\Controllers;

use App\Exports\CrudExampleExport;
use App\Exports\RoleExampleExport;
use App\Http\Requests\ImportExcelRequest;
use App\Http\Requests\RoleRequest;
use App\Imports\RoleImport;
use App\Repositories\UserRepository;
use App\Services\FileService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RoleController extends Controller
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
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->userRepository = new UserRepository;
        $this->fileService    = new FileService;

        $this->middleware('can:Role');
        $this->middleware('can:Role Tambah')->only(['create', 'store']);
        $this->middleware('can:Role Ubah')->only(['edit', 'update']);
        $this->middleware('can:Role Hapus')->only(['destroy']);
    }

    /**
     * showing user management page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.user-management.roles.index', [
            'data'           => $this->userRepository->getRoles(),
            'canImportExcel' => $user->can('Pengguna Impor Excel'),
            'canCreate'      => $user->can('Pengguna Tambah'),
            'canUpdate'      => $user->can('Pengguna Ubah'),
            'canDelete'      => $user->can('Pengguna Hapus'),
        ]);
    }

    /**
     * showing create role page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.user-management.roles.form', [
            'permissionGroups' => $this->userRepository->getPermissionGroupWithChild(),
            'action'           => route('user-management.roles.store'),
            'actionType'       => CREATE
        ]);
    }

    /**
     * store role data
     *
     * @param RoleRequest $request
     * @return Response
     */
    public function store(RoleRequest $request)
    {
        $result = $this->userRepository->createRole($request->name, $request->only(['permissions']));
        logCreate('Role', $result);
        $successMessage = successMessageCreate('Role Dan Permission');
        return back()->with('successMessage', $successMessage);
    }

    /**
     * showing edit role page
     *
     * @param Role $role
     * @return Response
     */
    public function edit(Role $role)
    {
        $role->load(['permissions']);
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('stisla.user-management.roles.form', [
            'd'                => $role,
            'rolePermissions'  => $rolePermissions,
            'permissionGroups' => $this->userRepository->getPermissionGroupWithChild(),
            'action'           => route('user-management.roles.update', [$role->id]),
            'actionType'       => UPDATE
        ]);
    }

    /**
     * update role data
     *
     * @param Request $request
     * @param Role $role
     * @return Response
     */
    public function update(Request $request, Role $role)
    {
        if ($role->is_locked) abort(404);
        $before = $this->userRepository->findRole($role->id);
        $after = $this->userRepository->updateRole($role->id, $request->only(['permissions']));
        logUpdate('Role', $before, $after);
        $successMessage = successMessageUpdate('Role Dan Permission');
        return back()->with('successMessage', $successMessage);
    }

    /**
     * delete role data
     *
     * @param Role $role
     * @return Response
     */
    public function destroy(Role $role)
    {
        DB::beginTransaction();
        try {
            if ($role->is_locked) abort(404);
            $before = $this->userRepository->findRole($role->id);
            $this->userRepository->deleteRole($role->id);
            logDelete('Role', $before);
            DB::commit();
            $successMessage = successMessageDelete('Role Dan Permission');
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
        $excel = new RoleExampleExport($this->userRepository->getRoles());
        return $this->fileService->downloadExcel($excel, 'role_import_examples.xlsx');
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
            $this->fileService->importExcel(new RoleImport, $request->file('import_file'));
            DB::commit();
            return back()->with('successMessage', __('Impor berhasil dilakukan'));
        } catch (Exception $exception) {
            DB::rollBack();
            return back()->with('errorMessage', $exception->getMessage());
        }
    }
}
