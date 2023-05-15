<?php

namespace Modules\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Blog\Contracts\Repositories\ArticleRepositoryInterface;
use Modules\Blog\Repositories\ArticleRepository;

class ArticleRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ArticleRepositoryInterface::class,
            ArticleRepository::class
        );
    }
}
