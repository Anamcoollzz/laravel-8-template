<?php

namespace App\Http\Requests;

use App\Repositories\SettingRepository;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (new SettingRepository)->isForgotPasswordSendToEmail();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $isGoogleCaptcha = SettingRepository::isGoogleCaptchaForgotPassword();
        return [
            'email'                => 'required|email|exists:users',
            'g-recaptcha-response' => $isGoogleCaptcha ? 'required|captcha' : 'nullable'
        ];
    }
}
