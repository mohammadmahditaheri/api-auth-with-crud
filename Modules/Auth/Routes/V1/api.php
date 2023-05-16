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

// forgot password action (request reset password secret)
Route::post('/forgot-password', [ResetPasswordController::class, 'forgotPassword'])
    ->middleware([
        'email_exists_for_reset',
        'has_not_requested_reset_recently'
    ]);

// reset password
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])
    ->middleware([
        'email_exists_for_reset',
    ]);
