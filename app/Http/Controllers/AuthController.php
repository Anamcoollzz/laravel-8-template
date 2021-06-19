<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
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
    }

    /**
     * showing login form page
     *
     * @return Response
     */
    public function loginForm()
    {
        return view('auth.login.index');
    }

    /**
     * process login
     *
     * @param LoginRequest $request
     * @return Response
     */
    public function login(LoginRequest $request)
    {
        $user = $this->userRepository->findByEmail($request->email);
        if (Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->filled('remember'));
            return redirect()->route('dashboard.index')->with('successMessage', __('Sukses masuk ke dalam sistem'));
        }
        return redirect()->back()->withInput()->with('errorMessage', __('Password yang dimasukkan salah'));
    }

    /**
     * logout from system
     *
     * @return Response
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
