<?php


use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\V1\FinalizeRegisterController;
use Modules\Auth\Http\Controllers\V1\RegisterController;

// register first action
Route::post('/register', RegisterController::class)
    ->name('register')
    ->middleware([
        'email_doesnt_exist'
    ]);

// register second action (finalization)
Route::post('/finalize-register', FinalizeRegisterController::class)
    ->middleware([
        'secret_matches',
    ])
    ->name('finalize-register');
