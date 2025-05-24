<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function laravelLoggerActivity(Request $request)
    {
        return view('log.laravel-logger-activity');
    }
}
