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
        if (config('app.template') === 'stisla') {

            if ($this->type === 'umum')
                return [
                    'application_name'    => 'required',
                    'company_name'        => 'required',
                    'since'               => 'required|numeric',
                    'application_version' => 'required',
                ];
            else if ($this->type === 'tampilan')
                return [
                    'stisla_skin' => 'required',
                    'favicon'     => 'nullable|file',
                ];
            else if ($this->type === 'lainnya')
                return [
                    'login_must_verified' => 'required|numeric',
                ];
            else if ($this->type === 'email')
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
