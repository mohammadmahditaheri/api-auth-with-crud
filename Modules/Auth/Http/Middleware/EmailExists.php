<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Auth\Contracts\Repositories\UserRepositoryInterface;
use Modules\Auth\Traits\Responses\FormatsAuthResponses;
use Symfony\Component\HttpFoundation\Response;

class EmailExists
{
    use FormatsAuthResponses;

    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->exists('email') &&
            $request->input('email') != null &&
            $this->repository->emailExists($request->input('email'))) {
            return $this->secretMailedSuccessfully();
        }

        return $next($request);
    }
}
