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
        if (config('app.template') === 'stisla') {
            $template = \App\Models\Setting::firstOrCreate(['key' => 'login_template'], ['value' => 'default'])->value;
            if ($template === 'tampilan 2')
                return view('auth.login.index-stisla-2');
            else
                return view('auth.login.index-stisla');
        }
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
            $user->update(['last_login' => now()]);
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
