<?php

namespace App\Http\Requests;

use App\Repositories\SettingRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (Route::is('api.reset-password')) {
            return [
                'new_password'              => 'required|min:6|confirmed',
                'new_password_confirmation' => 'required|min:6',
                "email"                     => 'required|exists:users,email',
                "verification_code"         => 'required|exists:users,verification_code',
                "verification_token"        => 'required|exists:users,email_token',
            ];
        }

        $isGoogleCaptcha = SettingRepository::isGoogleCaptchaResetPassword();

        return [
            'new_password'              => 'required|min:6|confirmed',
            'new_password_confirmation' => 'required|min:6',
            'g-recaptcha-response'      => $isGoogleCaptcha ? 'required|captcha' : 'nullable',
        ];
    }
}
