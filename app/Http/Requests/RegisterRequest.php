<?php

namespace App\Http\Requests;

use App\Repositories\SettingRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (new SettingRepository)->isActiveRegisterPage();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (Route::is('api.register')) {
            return [
                'name'                  => 'required',
                'email'                 => 'required|email|unique:users,email',
                'password'              => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ];
        }

        $isGoogleCaptcha = SettingRepository::isGoogleCaptchaRegister();

        return [
            'name'                  => 'required',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'g-recaptcha-response'  => $isGoogleCaptcha ? 'required|captcha' : 'nullable'
        ];
    }
}
