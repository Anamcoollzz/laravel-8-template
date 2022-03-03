<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\UserRepository;

class UserManagementController extends Controller
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
        $this->middleware('can:Pengguna');
        $this->middleware('can:Pengguna Tambah')->only(['create', 'store']);
        $this->middleware('can:Pengguna Ubah')->only(['edit', 'update']);
        $this->middleware('can:Pengguna Hapus')->only(['destroy']);
    }

    /**
     * showing user management page
     *
     * @return Response
     */
    public function index()
    {
        $data = $this->userRepository->getPaginateUsers(request('perPage'));
        return response200($data, __('Berhasil mengambil data pengguna'));
    }

    /**
     * save new user to db
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $user = $this->userRepository->create(
            array_merge(
                ['password' => bcrypt($request->password)],
                $request->only(['name', 'email'])
            )
        );
        $user->assignRole($request->role);
        return response200($user, __('Berhasil menambah data pengguna'));
    }

    /**
     * update user to db
     *
     * @param UserRequest $request
     * @param User $user
     * @return Response
     */
    public function update(UserRequest $request, User $user)
    {
        $this->userRepository->update(
            array_merge(
                ['password' => $request->filled('password') ? bcrypt($request->password) : $user->password],
                $request->only(['name', 'email'])
            ),
            $user->id
        );
        $user->syncRoles([$request->role]);
        return redirect()->back()->with('successMessage', __('Berhasil memperbarui pengguna'));
    }

    /**
     * delete user from db
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        $user = $this->userRepository->delete(
            $user->id
        );
        return redirect()->back()->with('successMessage', __('Berhasil menghapus pengguna'));
    }
}
