<?php

use App\Http\Controllers\Admin\SendEmailsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\JobBoardController;
use App\Http\Controllers\Webhook\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/job-board', [JobBoardController::class, 'index'])->name('job-board');
Route::get('/vagas/{id}', [JobBoardController::class, 'details'])->name('job-board.details');

Route::get('/register', [RegisterController::class, 'show'])->name('register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/register/success', [RegisterController::class, 'success'])->name('register.success');
Route::get('/register/cancel', [RegisterController::class, 'cancel'])->name('register.cancel');

Route::post('/webhooks/stripe', StripeWebhookController::class)->name('webhooks.stripe');

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/admin/send-emails', SendEmailsController::class)->name('admin.send-emails');
    Route::post('/vagas/{vaga}/apply', [JobBoardController::class, 'apply'])->name('job-board.apply');
});
