<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentTypeRequest extends FormRequest
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
				'type_name' => ["required"],
				'bill_amount' => ["required"],
				'payment_time_type' => ["required"],

            ];
        }
        return [
			'type_name' => ["required"],
			'bill_amount' => ["required"],
			'payment_time_type' => ["required"],

        ];
    }
}
