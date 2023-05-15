<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Auth\Contracts\Repositories\UserRepositoryInterface;
use Modules\Auth\Traits\Responses\FormatsAuthErrorResponses;
use Symfony\Component\HttpFoundation\Response;

class SecretMatches
{
    use FormatsAuthErrorResponses;

    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->secretDoesntMatch($request)) {
            throw $this->finalizeRegistrationFailed();
        }

        return $next($request);
    }

    private function secretDoesntMatch(Request $request): bool
    {
        $user = $this->repository->findByEmail($request->input('email'));

        return !$user ||
            !$request->has('secret') ||
            !$this->repository->secretMatches($user, $request->input('secret'));
    }
}
