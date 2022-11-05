<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
        if (TEMPLATE === STISLA) {

            if ($this->type === 'umum')
                return [
                    'application_name'    => 'required',
                    'company_name'        => 'required',
                    'since'               => 'required|numeric',
                    'application_version' => 'required',
                ];
            else if ($this->type === 'meta')
                return [
                    'meta_author'         => 'required',
                    'meta_description'    => 'required',
                    'meta_keywords'       => 'required',
                ];
            else if ($this->type === 'tampilan')
                return [
                    'stisla_skin'         => 'required',
                    'stisla_sidebar_mini' => 'required',
                    'favicon'             => 'nullable|file',
                    'logo'                => 'nullable|file',
                    'stisla_bg_home'      => 'nullable|file',
                    'stisla_bg_login'     => 'nullable|file',
                ];
            else if ($this->type === 'lainnya') {
                return [
                    'is_login_must_verified'            => 'required|numeric',
                    'is_active_register_page'           => 'required|numeric',
                    'is_forgot_password_send_to_email'  => 'required|numeric',
                    'is_google_captcha_login'           => 'required|numeric',
                    'is_google_captcha_register'        => 'required|numeric',
                    'is_google_captcha_forgot_password' => 'required|numeric',
                    'is_google_captcha_reset_password'  => 'required|numeric',
                ];
            } else if ($this->type === 'email')
                return [
                    'mail_from_address' => 'required',
                    'mail_from_name'    => 'required',
                    'mail_host'         => 'required',
                    'mail_port'         => 'required',
                    'mail_username'     => 'required',
                    'mail_password'     => 'required',
                    'mail_encryption'   => 'required',
                ];
        } else
            return [
                'application_name' => 'required',
                'company_name'     => 'required',
                'since'            => 'required|numeric',
                'version'          => 'required',
            ];
    }
}
