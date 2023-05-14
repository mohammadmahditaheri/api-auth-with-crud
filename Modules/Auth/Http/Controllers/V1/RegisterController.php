<?php

namespace Modules\Auth\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Auth\Contracts\Repositories\UserRepositoryInterface;
use Modules\Auth\Contracts\Services\MailSecretHandler\MailHandlerInterface;
use Modules\Auth\Http\Requests\RegisterUserRequest;
use Modules\Auth\Traits\Responses\FormatsAuthResponses;

class RegisterController extends Controller
{
    use FormatsAuthResponses;

    public function __construct(
        private UserRepositoryInterface $repository,
        private MailHandlerInterface $mailHandler
    )
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterUserRequest $request): Response
    {
        // make user
        $user = $this->repository->create($request->validated());

        // set secret and send it to email
        $result = $this->mailHandler->handle($user);

        return $this->secretMailedSuccessfully();
    }
}
