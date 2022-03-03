<?php

namespace App\Http\Controllers;

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
        return view('stisla.user-management.users.index', [
            'data' => $this->userRepository->getUsers(),
        ]);
    }

    /**
     * showing add new user page
     *
     * @return Response
     */
    public function create()
    {
        $roleOptions = $this->userRepository->getRoles()->pluck('name', 'id')->toArray();
        return view('stisla.user-management.users.form', [
            'roleOptions' => $roleOptions,
        ]);
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
        return redirect()->back()->with('successMessage', __('Berhasil menambah pengguna'));
    }

    /**
     * showing edit user page
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        $roleOptions = $this->userRepository->getRoles()->pluck('name', 'id')->toArray();
        if ($user->roles->count() > 0)
            $user->role = $user->roles[0]->id;
        return view('stisla.user-management.users.form', [
            'roleOptions' => $roleOptions,
            'd'           => $user,
        ]);
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
        $this->userRepository->delete($user->id);
        logDelete(__('Menghapus Pengguna'), $user);
        return redirect()->back()->with('successMessage', __('Berhasil menghapus pengguna'));
    }
}
