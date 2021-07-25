<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Mail\TestingMail;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TestingController extends Controller
{
    public function datatable()
    {
        return view('testing.datatable');
    }

    public function sendEmail()
    {
        (new EmailService)->testing('hairulanam21@gmail.com', Str::random(20));
    }

    public function modal()
    {
        return view('testing.modal');
    }
}
