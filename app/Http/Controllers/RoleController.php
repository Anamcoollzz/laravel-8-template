<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * user repository
     *
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->userRepository = new UserRepository;
        $this->middleware('can:Role');
        $this->middleware('can:Role Ubah')->only(['edit', 'update']);
    }

    /**
     * showing user management page
     *
     * @return Response
     */
    public function index()
    {
        return view('stisla.user-management.roles.index', [
            'data' => $this->userRepository->getRoles(),
        ]);
    }

    /**
     * showing edit user management page
     *
     * @return Response
     */
    public function edit(Role $role)
    {
        $role->load(['permissions']);
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        // dd($rolePermissions);
        return view('stisla.user-management.roles.form', [
            'd'               => $role,
            'permissions'     => $this->userRepository->getPermissions(),
            'rolePermissions' => $rolePermissions,
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
        if ($role->name === 'superadmin') abort(404);
        $this->userRepository->updateRole($role->id, $request->only(['permissions']));
        return redirect()->back()->with('successMessage', __('Berhasil memperbarui role'));
    }
}
