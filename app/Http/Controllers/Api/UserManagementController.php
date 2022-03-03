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
                [
                    'password' => bcrypt($request->password)
                ],
                $request->only([
                    'name',
                    'email'
                ])
            )
        );
        $user->assignRole($request->role);
        logCreate(__('Menambah Pengguna Baru'), $user);
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
        $data = $request->only([
            'name',
            'email'
        ]);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $userNew = $this->userRepository->update($data, $user->id);
        $userNew->syncRoles([$request->role]);
        logUpdate(__("Perbarui Pengguna"), $user, $userNew);
        return response200($user, __('Berhasil memperbarui data pengguna'));
    }

    /**
     * delete user from db
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        $deleted = $this->userRepository->delete($user->id);
        logDelete(__('Menghapus Pengguna'), $user);
        return response200($deleted, __('Berhasil menghapus pengguna'));
    }
}
