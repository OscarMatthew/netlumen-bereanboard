<?php

namespace App\Services;

use App\Jobs\SendToSlack;
use Illuminate\Support\Facades\App;

class Alert
{
    public static function slack($message)
    {
        //if (App::environment() === 'production') {
            dispatch((new SendToSlack($message))->onQueue('slack-alert'));
        //}
    }
}
