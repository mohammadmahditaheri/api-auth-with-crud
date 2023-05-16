<?php

namespace Modules\Auth\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Auth\Contracts\Actions\SendResetSecretHandlerInterface;
use Modules\Auth\Contracts\Repositories\ResetPasswordRepoInterface;
use Modules\Auth\Http\Requests\ForgotPasswordRequest;
use Modules\Auth\Http\Requests\ResetPasswordRequest;
use Modules\Auth\Traits\Responses\FormatsResetErrorResponses;
use Modules\Auth\Traits\Responses\FormatsResetResponses;

class ResetPasswordController extends Controller
{
    use FormatsResetResponses,
        FormatsResetErrorResponses;

    public function __construct(
        private SendResetSecretHandlerInterface $handler,
        private ResetPasswordRepoInterface $repository
    )
    {
    }

    /**
     * manages sending secret code to user
     *
     * @param ForgotPasswordRequest $request
     * @return Response
     */
    public function forgotPassword(ForgotPasswordRequest $request): Response
    {
        // send code by email via handler
        $result = $this->handler->handle($request->validated('email'));

        return $this->resetSecretSent();
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $result = $this->repository->reset(
            newPassword: $request->validated('password'),
            email: $request->validated('email'),secret: $request->validated('secret')
        );

        if (!$result) {
            throw $this->resetFailed();
        }

        return $this->resetPasswordIsSuccessful();
    }
}
