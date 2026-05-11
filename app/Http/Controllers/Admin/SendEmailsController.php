<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SendEmailsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        Artisan::call('app:send-emails-command');

        return \Illuminate\Support\Facades\Redirect::back()->with('success', 'Emails enviados com sucesso!');
    }
}
