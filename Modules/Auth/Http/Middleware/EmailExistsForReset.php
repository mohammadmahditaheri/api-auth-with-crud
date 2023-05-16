<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Auth\Contracts\Repositories\UserRepositoryInterface;
use Modules\Auth\Traits\Responses\FormatsResetResponses;

class EmailExistsForReset
{
    use FormatsResetResponses;

    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!$this->repository->emailExists($request->input('email'))
        ) {
            // although the email in this case does not exist
            // we pretend that the email exists, and we have sent a code
            // to user's email
            return $this->resetSecretSent();
        }

        return $next($request);
    }
}
