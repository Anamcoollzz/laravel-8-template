<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrudExampleRequest extends FormRequest
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
        return [
            'text'     => 'required',
            "number"   => "required|numeric",
            "select"   => "required",
            "textarea" => "required",
            "checkbox" => "required|array",
            "radio"    => "required",
            "file"     => $this->isMethod('put') ? '' : "required|file",
            "date"     => "required|date",
            "time"     => "required",
            "color"    => "required",
        ];
    }
}
