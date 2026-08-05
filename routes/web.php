<?php

use App\Http\Controllers\Admin\SendEmailsController;
use App\Http\Controllers\JobBoardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/job-board', [JobBoardController::class, 'index'])->name('job-board');
Route::get('/vagas/{id}', [JobBoardController::class, 'details'])->name('job-board.details');

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/admin/send-emails', SendEmailsController::class)->name('admin.send-emails');
    Route::post('/vagas/{vaga}/apply', [JobBoardController::class, 'apply'])->name('job-board.apply');
});
