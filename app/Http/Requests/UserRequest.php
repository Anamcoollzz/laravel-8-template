<?php

namespace App\Http\Requests;

use App\Repositories\UserRepository;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            $user = (new UserRepository)->findByEmail($this->email);
            return [
                'name'  => 'required',
                'email' => 'required|email|unique:users,email,' . ($user->id ?? null) . ',id',
                'role'  => 'required'
            ];
        }
        return [
            'name'  => 'required',
            'email' => 'required|unique:users,email',
            'role'  => 'required'
        ];
    }
}
