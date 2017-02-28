<?php

namespace App\Http\Controllers;

use App\Jobs\SendGeneralEmail;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:send-email');
    }

    public function create()
    {
        return view('email.create');
    }

    public function send()
    {
        $this->validate(request(), [
            'to' => 'email',
            'subject' => 'required',
            'body' => 'required'
        ]);

        dispatch((new SendGeneralEmail(request('to'), request('subject'), request('body')))->onQueue('email'));

        return redirect('/email-sent');
    }

    public function sent()
    {
        return view('email.sent');
    }
}
