<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
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
     * setting repository
     *
     * @var SettingRepository
     */
    private SettingRepository $settingRepository;

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
        $this->userRepository    = new UserRepository;
        $this->settingRepository = new SettingRepository;
        $this->emailService      = new EmailService;
    }

    /**
     * showing register form page
     *
     * @return Response
     */
    public function registerForm()
    {
        if ($this->settingRepository->isActiveRegisterPage() === false)
            abort(404);

        // if (config('app.template') === 'stisla') {
        //     $template = \App\Models\Setting::firstOrCreate(['key' => 'login_template'], ['value' => 'default'])->value;
        //     if ($template === 'tampilan 2')
        //         return view('stisla.auth.login.index-stisla-2');
        //     else
        //         return view('stisla.auth.login.index-stisla');
        // }
        // return view('stisla.auth.login.index');
        if (TEMPLATE === STISLA)
            return view('stisla.auth.register.index');
    }

    /**
     * process register
     *
     * @param RegisterRequest $request
     * @return Response
     */
    public function register(RegisterRequest $request)
    {
        $data = array_merge([
            'password' => bcrypt($request->password)
        ], $request->only(
            [
                'name', 'email'
            ]
        ));
        $user = $this->userRepository->create($data);
        if ($this->settingRepository->loginMustVerified()) {
            $user->update(['email_token' => Str::random(150)]);
            $this->emailService->verifyAccount($user);
            return Helper::redirectSuccess(route('login'), __('Cek inbox email anda untuk memverifikasi akun terlebih dahulu'));
        }
        Auth::login($user);
        $user->update(['last_login' => now()]);
        return redirect()->route('dashboard.index')->with('successMessage', __('Sukses mendaftar dan masuk ke dalam sistem'));
    }

    /**
     * showing login form page
     *
     * @return Response
     */
    public function loginForm()
    {
        if (TEMPLATE === STISLA) {
            $template = $this->settingRepository->stislaLoginTemplate();
            $data     = [];
            if ($template === 'tampilan 2')
                return view('stisla.auth.login.index2', $data);
            else
                return view('stisla.auth.login.index', $data);
        }
        return view('stisla.auth.login.index');
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
            $loginMustVerified = $this->settingRepository->loginMustVerified();
            if ($loginMustVerified) {
                if ($user->email_verified_at === null) {
                    return Helper::backError(['email' => __('Email belum diverifikasi')]);
                }
            }
            Auth::login($user, $request->filled('remember'));
            $user->update(['last_login' => now()]);
            logLogin();
            return Helper::redirectSuccess(route('dashboard.index'), __('Sukses masuk ke dalam sistem'));
        }
        return Helper::backError(['password' => __('Password yang dimasukkan salah')]);
    }

    /**
     * logout from system
     *
     * @return Response
     */
    public function logout()
    {
        logLogout();
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }

    /**
     * showing forgot password page
     *
     * @return Response
     */
    public function forgotPasswordForm()
    {
        if ($this->settingRepository->isForgotPasswordSendToEmail() === false) abort(404);
        if (TEMPLATE === STISLA) {
            // $template = \App\Models\Setting::firstOrCreate(['key' => 'login_template'], ['value' => 'default'])->value;
            // if ($template === 'tampilan 2')
            // return view('stisla.auth.login.index-stisla-2');
            // else
            return view('stisla.auth.forgot-password.index2');
        }
        return view('stisla.auth.login.index');
    }

    /**
     * process forgot password
     *
     * @param ForgotPasswordRequest $request
     * @return Response
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        if ($this->settingRepository->isForgotPasswordSendToEmail() === false) abort(404);
        DB::beginTransaction();
        try {
            $user = $this->userRepository->findByEmail($request->email);
            $user->update(['email_token' => Str::random(100)]);
            $this->emailService->forgotPassword($user);
            DB::commit();
            return back()->withInput()->with('successMessage', __('Sukses mengirim ke ' . $request->email));
        } catch (Exception $e) {
            DB::rollBack();
            // if (Str::contains($e->getMessage(), 'Connection could not be established')) {
            return back()->withInput()->with('errorMessage', __('Gagal mengirim email, server email sedang gangguan'));
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
        if ($this->settingRepository->isForgotPasswordSendToEmail() === false) abort(404);
        $user = $this->userRepository->findByEmailToken($token);
        if ($user === null)
            abort(404);
        if (TEMPLATE === STISLA) {
            // $template = \App\Models\Setting::firstOrCreate(['key' => 'login_template'], ['value' => 'default'])->value;
            // if ($template === 'tampilan 2')
            // return view('stisla.auth.login.index-stisla-2');
            // else
            return view('stisla.auth.reset-password.index-stisla-2');
        }
        return view('stisla.auth.login.index');
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
        if ($this->settingRepository->isForgotPasswordSendToEmail() === false) abort(404);
        DB::beginTransaction();
        try {
            $user = $this->userRepository->findByEmailToken($token);
            if ($user === null)
                return back()->withInput()->with('errorMessage', __('Gagal memperbarui password'));
            $user->update(['password' => bcrypt($request->new_password), 'email_token' => null]);
            DB::commit();
            return redirect()->route('login')->withInput()->with('successMessage', __('Sukses memperbarui password'));
        } catch (Exception $e) {
            return back()->withInput()->with('errorMessage', __('Gagal memperbarui password'));
        }
    }

    /**
     * showing verification form page
     *
     * @return Response
     */
    public function verificationForm()
    {
        if ($this->settingRepository->loginMustVerified() === false) abort(404);
        // if (config('app.template') === 'stisla') {
        //     $template = \App\Models\Setting::firstOrCreate(['key' => 'login_template'], ['value' => 'default'])->value;
        //     if ($template === 'tampilan 2')
        //         return view('stisla.auth.login.index-stisla-2');
        //     else
        //         return view('stisla.auth.login.index-stisla');
        // }
        // return view('stisla.auth.login.index');
        if (TEMPLATE === STISLA)
            return view('stisla.auth.verification.index2');
    }

    /**
     * process forgot password
     *
     * @param ForgotPasswordRequest $request
     * @return Response
     */
    public function verification(ForgotPasswordRequest $request)
    {
        if ($this->settingRepository->loginMustVerified() === false) abort(404);
        DB::beginTransaction();
        try {
            $user = $this->userRepository->findByEmail($request->email);
            $user->update(['email_token' => Str::random(150)]);
            $this->emailService->verifyAccount($user);
            DB::commit();
            return back()->withInput()->with('successMessage', __('Sukses mengirim link verifikasi ke ' . $request->email));
        } catch (Exception $e) {
            DB::rollBack();
            // if (Str::contains($e->getMessage(), 'Connection could not be established')) {
            return back()->withInput()->with('errorMessage', __('Gagal mengirim email, server email sedang gangguan'));
            // }
            // return $e->getMessage();
        }
    }

    /**
     * process verify account
     *
     * @param mixed $token
     * @return Response
     */
    public function verify($token)
    {
        if ($this->settingRepository->loginMustVerified() === false) abort(404);
        $user = $this->userRepository->findByEmailToken($token);
        if ($user === null) {
            abort(404);
        }
        $user->update(['email_verified_at' => now(), 'email_token' => null]);
        return redirect()->route('login')->with('successMessage', __('Sukses memverifikasi akun, silakan masuk menggunakan akun anda'));
    }
}
