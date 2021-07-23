<?php

namespace App\Helpers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class Helper
{

    /**
     * back with error message
     *
     * @param array $errorMessages
     * @return RedirectResponse
     */
    public static function backError(array $errorMessages)
    {
        $validator = Validator::make([], []);
        foreach ($errorMessages as $key => $value) {
            $validator->getMessageBag()->add($key, $value);
        }
        return redirect()->back()->withInput()->withErrors($validator);
    }

    /**
     * redirectWithSuccess
     *
     * @param string $route
     * @param string $message
     * @return RedirectResponse
     */
    public static function redirectSuccess(string $route, string $message)
    {
        return redirect($route)->with('successMessage', $message);
    }
}
