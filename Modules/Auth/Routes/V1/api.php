<?php


use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\V1\FinalizeRegisterController;
use Modules\Auth\Http\Controllers\V1\LoginController;
use Modules\Auth\Http\Controllers\V1\RegisterController;
use Modules\Auth\Http\Controllers\V1\ResetPasswordController;

// register first action
Route::post('/register', RegisterController::class)
    ->middleware([
        'email_doesnt_exist'
    ])->name('register');

// register second action (finalization)
Route::post('/finalize-register', FinalizeRegisterController::class)
    ->middleware([
        'secret_matches',
    ])
    ->name('finalize-register');

// login
Route::post('/login', LoginController::class)->name('login');

// forgot: request reset password action
Route::post('/forgot-password', [ResetPasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);
