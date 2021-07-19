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
        if (config('app.template') === 'stisla')
            return [
                'application_name'    => 'required',
                'company_name'        => 'required',
                'since'               => 'required|numeric',
                'application_version' => 'required',
                'stisla_skin'         => 'required',
            ];
        else
            return [
                'application_name' => 'required',
                'company_name'     => 'required',
                'since'            => 'required|numeric',
                'version'          => 'required',
            ];
    }
}
