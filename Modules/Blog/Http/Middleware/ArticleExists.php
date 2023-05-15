<?php

namespace Modules\Blog\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Blog\Contracts\Repositories\ArticleRepositoryInterface;
use Modules\Blog\Responses\FormatsArticleErrorResponses;
use Symfony\Component\HttpFoundation\Response;

class ArticleExists
{
    use FormatsArticleErrorResponses;

    public function __construct(private ArticleRepositoryInterface $repository)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->repository->exists($request->route('article'))) {
            throw $this->articleNotFound();
        }

        return $next($request);
    }
}
