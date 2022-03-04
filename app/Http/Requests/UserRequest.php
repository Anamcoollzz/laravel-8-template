<?php

namespace App\Http\Requests;

use App\Repositories\UserRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

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
            if (Route::is('api.users.update-password')) {
                $user = (new UserRepository)->find($this->user->id ?? $this->user);
                return [
                    'current_password'          => [
                        'required', 'min:6', function ($attribute, $value, $fail) use ($user) {
                            if (!Hash::check($value, $user->password)) {
                                $fail('Kata sandi yang dimasukkan salah.');
                            }
                        },
                    ],
                    'new_password'              => 'required|min:6|confirmed',
                    'new_password_confirmation' => 'required|min:6',
                ];
            }
            if (Route::is('api.users.update')) {
                $user = (new UserRepository)->find($this->user->id ?? $this->user);
                return [
                    'name'  => 'required',
                    'email' => 'required|email|unique:users,email,' . ($user->id ?? null) . ',id',
                    'role'  => 'required',
                ];
            }
            $user = (new UserRepository)->findByEmail($this->email);
            return [
                'name'  => 'required',
                'email' => 'required|email|unique:users,email,' . ($user->id ?? null) . ',id',
                'role'  => 'required'
            ];
        }
        if (Route::is('api.users.store')) {
            return [
                'name'                  => 'required',
                'email'                 => 'required|unique:users,email',
                'role'                  => 'required',
                'password'              => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ];
        }
        return [
            'name'  => 'required',
            'email' => 'required|unique:users,email',
            'role'  => 'required'
        ];
    }
}
