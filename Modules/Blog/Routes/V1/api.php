<?php


use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\V1\ArticleController;

Route::name('articles.')->middleware('auth:sanctum')->prefix('/articles')->group(function () {
    Route::controller(ArticleController::class)->group(function () {
        // commands (protected)
        Route::post('/', 'store')->name('store');
        Route::put('/{article}', 'update')
            ->whereNumber('article')
            ->middleware([
                'article_exists',
                'owns_article'
            ])
            ->name('update');
        Route::delete('/{article}', 'destroy')
            ->whereNumber('article')
            ->middleware([
                'article_exists',
                'owns_article'
            ])
            ->name('delete');

        // get own articles
        Route::get('/own', 'showOwn')->name('own');
    });
});

Route::name('articles.')->prefix('/articles')->controller(ArticleController::class)->group(function () {
    // index
    Route::get('/', 'index')
        ->name('index');

    // show
    Route::get('/{article}', 'show')
        ->whereNumber('article')
        ->middleware('article_exists')
        ->name('show');
});
