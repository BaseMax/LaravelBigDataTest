<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail()
    {
        $mail = [
            "title" => "this is title",
            "body" => "this is body",
        ];
        Mail::to(env("MAIL_USERNAME"))->send(new TestMail($mail));
        return "Email sent";
    }
}
