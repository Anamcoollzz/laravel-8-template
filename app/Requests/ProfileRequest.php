<?php

namespace App\Http\Requests;

use App\Repositories\UserRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ProfileRequest extends FormRequest
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
        if (Route::is('profile.update-password')) {
            return [
                'password' => 'required|min:6'
            ];
        }
        $user = (new UserRepository)->findByEmail($this->email);
        return [
            'name'   => 'required',
            'avatar' => 'nullable|image',
            'email'  => 'required|email|unique:users,email,' . ($user->id ?? null) . ',id'
        ];
    }
}
