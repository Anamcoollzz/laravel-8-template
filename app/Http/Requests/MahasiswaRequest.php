<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MahasiswaRequest extends FormRequest
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
        if ($this->isMethod('put')) {
            return [
				'name' => ["required"],
				'birth_date' => ["required","date_format:Y-m-d"],
				'select2' => ["required"],
				'select' => ["required"],
				'colorpicker' => ["required"],
				'number' => ["required"],
				'image' => ["required"],
				'file' => ["required"],
				'password' => ["required"],
				'email' => ["required"],
				'time' => ["required"],
				'address' => ["required"],
				'gender' => ["required"],

            ];
        }
        return [
			'name' => ["required"],
			'birth_date' => ["required","date_format:Y-m-d"],
			'select2' => ["required"],
			'select' => ["required"],
			'colorpicker' => ["required"],
			'number' => ["required"],
			'image' => ["required"],
			'file' => ["required"],
			'password' => ["required"],
			'email' => ["required"],
			'time' => ["required"],
			'address' => ["required"],
			'gender' => ["required"],

        ];
    }
}
