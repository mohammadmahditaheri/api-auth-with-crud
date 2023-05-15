<?php

namespace Modules\Auth\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Auth\Contracts\Repositories\UserRepositoryInterface;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Traits\Responses\FormatsAuthErrorResponses;
use Modules\Auth\Traits\Responses\FormatsLoginResponse;

class LoginController extends Controller
{
    use FormatsAuthErrorResponses,
        FormatsLoginResponse;

    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request): Response
    {
        // check validity
        if (! $this->repository->loginCredentialsMatch(
            $request->validated('email'),
            $request->validated('password')
        )) {
            throw $this->loginFailed();
        }

        // fetch user
        $user = $this->repository->findByEmail($request->validated('email'));

        // generate token
        $loginToken = $user->createToken('login');

        return $this->loggedInSuccessfully(
            user: $user,
            token: $loginToken->plainTextToken
        );
    }
}
