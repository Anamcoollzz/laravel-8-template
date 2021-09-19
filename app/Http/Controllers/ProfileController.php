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
        if ($request->hasFile('avatar')) {
            $this->userRepository->updateProfile(
                array_merge(
                    $request->only([
                        'name', 'email'
                    ]),
                    ['avatar' => $this->fileService->uploadAvatar($request->file('avatar'))],
                )
            );
        } else {
            $this->userRepository->updateProfile($request->only([
                'name', 'email'
            ]));
        }
        return back()->with('successMessage', __('Berhasil memperbarui profil'));
    }

    /**
     * update profile user login
     *
     * @param ProfileRequest $request
     * @return Response
     */
    public function updatePassword(ProfileRequest $request)
    {
        $this->userRepository->updateProfile([
            'password' => bcrypt($request->password)
        ]);
        return back()->with('successMessage', __('Berhasil memperbarui password'));
    }
}
