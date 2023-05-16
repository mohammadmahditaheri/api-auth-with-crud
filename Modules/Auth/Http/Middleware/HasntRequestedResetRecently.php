<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Auth\Contracts\Repositories\ResetPasswordRepoInterface;
use Modules\Auth\Traits\Responses\FormatsResetResponses;
use Symfony\Component\HttpFoundation\Response;

class HasntRequestedResetRecently
{
    use FormatsResetResponses;

    public function __construct(private ResetPasswordRepoInterface $resetRepository)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $reset = $this->resetRepository->find($request->input('email'));
        if ($reset &&
            $reset->secret_expires_at > now()
        ) {
            // pretend that we have send upon this request
            return $this->resetSecretSent();
        }

        return $next($request);
    }
}
