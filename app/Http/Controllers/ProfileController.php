<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Repositories\UserRepository;
use App\Services\FileService;

class ProfileController extends Controller
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
    }

    /**
     * showing profil page
     *
     * @return Response
     */
    public function index()
    {
        return view('stisla.profile.index', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * update profile user login
     *
     * @param ProfileRequest $request
     * @return Response
     */
    public function update(ProfileRequest $request)
    {
        $data = $request->only([
            'name',
            'email'
        ]);
        $user = auth()->user();
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->fileService->uploadAvatar($request->file('avatar'));
        }
        $newUser = $this->userRepository->updateProfile($data);
        logUpdate('Profil Pengguna', $user, $newUser);
        return back()->with('successMessage', __('Berhasil memperbarui profil'));
    }

    /**
     * update password user login
     *
     * @param ProfileRequest $request
     * @return Response
     */
    public function updatePassword(ProfileRequest $request)
    {
        $oldPassword = auth()->user()->password;
        $this->userRepository->updateProfile([
            'password' => $newPassword = bcrypt($request->password)
        ]);
        logUpdate('Kata Sandi', $oldPassword, $newPassword);
        return back()->with('successMessage', __('Berhasil memperbarui password'));
    }
}
