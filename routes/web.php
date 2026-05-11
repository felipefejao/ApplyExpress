<?php

use App\Http\Controllers\Admin\SendEmailsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/send-emails', SendEmailsController::class)->middleware(['auth', 'web'])->name('admin.send-emails');
