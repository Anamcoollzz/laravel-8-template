<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
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
        $this->middleware('can:Pengguna Force Login')->only(['forceLogin']);
    }

    /**
     * showing user management page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        $roleOptions = $this->userRepository->getRoles()->pluck('name', 'id')->toArray();
        return view('stisla.user-management.users.index', [
            'data'           => $this->userRepository->getUsers(),
            'canImportExcel' => $user->can('Pengguna Impor Excel'),
            'canCreate'      => $user->can('Pengguna Tambah'),
            'canUpdate'      => $user->can('Pengguna Ubah'),
            'canDelete'      => $user->can('Pengguna Hapus'),
            'canForceLogin'  => $user->can('Pengguna Force Login'),
            'roleCount'      => count($roleOptions),
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
            'isDetail'    => false,
            'action'      => __("Tambah"),
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
                    'email',
                    'phone_number',
                    'birth_date',
                    'address',
                ])
            )
        );
        $user->assignRole($request->role);
        logCreate('Pengguna', $user);
        $successMessage = successMessageCreate('Pengguna');
        return redirect()->back()->with('successMessage', $successMessage);
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
        if ($user->roles->count() > 1)
            $user->role = $user->roles->pluck('id')->toArray();
        else
            $user->role = $user->roles->first()->id ?? null;
        return view('stisla.user-management.users.form', [
            'roleOptions' => $roleOptions,
            'd'           => $user,
            'isDetail'    => false,
            'action'      => __("Ubah"),
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
            'email',
            'phone_number',
            'birth_date',
            'address',
        ]);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $userNew = $this->userRepository->update($data, $user->id);
        $userNew->syncRoles([$request->role]);
        logUpdate('Pengguna', $user, $userNew);
        $successMessage = successMessageUpdate('Pengguna');
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * showing detail user page
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        $roleOptions = $this->userRepository->getRoles()->pluck('name', 'id')->toArray();
        if ($user->roles->count() > 1)
            $user->role = $user->roles->pluck('id')->toArray();
        else
            $user->role = $user->roles->first()->id ?? null;
        return view('stisla.user-management.users.form', [
            'roleOptions' => $roleOptions,
            'd'           => $user,
            'isDetail'    => true,
            'action'      => __("Detail"),
        ]);
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
        logDelete('Pengguna', $user);
        $successMessage = successMessageDelete('Pengguna');
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * force login with specific user
     *
     * @param User $user
     * @return Response
     */
    public function forceLogin(User $user)
    {
        $this->userRepository->login($user);
        return Helper::redirectSuccess(route('dashboard.index'), __('Berhasil masuk ke dalam sistem'));
    }
}
