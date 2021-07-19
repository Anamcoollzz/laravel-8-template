<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    /**
     * user repository
     *
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * emailservice
     *
     * @var EmailService
     */
    private EmailService $emailService;

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->userRepository = new UserRepository;
        $this->emailService = new EmailService;
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

    /**
     * showing forgot password page
     *
     * @return Response
     */
    public function forgotPasswordForm()
    {
        if (config('app.template') === 'stisla') {
            // $template = \App\Models\Setting::firstOrCreate(['key' => 'login_template'], ['value' => 'default'])->value;
            // if ($template === 'tampilan 2')
            // return view('auth.login.index-stisla-2');
            // else
            return view('auth.forgot-password.index-stisla-2');
        }
        return view('auth.login.index');
    }

    /**
     * process forgot password
     *
     * @param ForgotPasswordRequest $request
     * @return Response
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->findByEmail($request->email);
            $user->update(['email_token' => Str::random(100)]);
            $this->emailService->forgotPassword($user);
            DB::commit();
            return redirect()->back()->withInput()->with('successMessage', __('Sukses mengirim ke ' . $request->email));
        } catch (Exception $e) {
            DB::rollBack();
            // if (Str::contains($e->getMessage(), 'Connection could not be established')) {
            return redirect()->back()->withInput()->with('errorMessage', __('Gagal mengirim email, server email sedang gangguan'));
            // }
            // return $e->getMessage();
        }
    }

    /**
     * showing reset password page
     *
     * @param mixed $token
     * @return Response
     */
    public function resetPasswordForm($token)
    {
        $user = $this->userRepository->findByEmailToken($token);
        if ($user === null)
            abort(404);
        if (config('app.template') === 'stisla') {
            // $template = \App\Models\Setting::firstOrCreate(['key' => 'login_template'], ['value' => 'default'])->value;
            // if ($template === 'tampilan 2')
            // return view('auth.login.index-stisla-2');
            // else
            return view('auth.reset-password.index-stisla-2');
        }
        return view('auth.login.index');
    }

    /**
     * process reset password
     *
     * @param mixed $token
     * @param ResetPasswordRequest $request
     * @return Response
     */
    public function resetPassword($token, ResetPasswordRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->findByEmailToken($token);
            if ($user === null)
                return redirect()->back()->withInput()->with('errorMessage', __('Gagal memperbarui password'));
            $user->update(['password' => bcrypt($request->new_password), 'email_token' => null]);
            DB::commit();
            return redirect()->route('login')->withInput()->with('successMessage', __('Sukses memperbarui password'));
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('errorMessage', __('Gagal memperbarui password'));
        }
    }
}
