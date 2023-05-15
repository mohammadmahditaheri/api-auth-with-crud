<?php


use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\V1\ArticleController;

Route::prefix('/articles')->controller(ArticleController::class)->group(function () {
    // commands (protected)
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/');
        Route::put('/{article}')->whereNumber('article');
        Route::delete('/{article}')->whereNumber('article');

        // get own articles
        Route::get('/own');
    });


    // queries (public)
    Route::get('/');
    Route::get('/{article}')->whereNumber('article');
});
