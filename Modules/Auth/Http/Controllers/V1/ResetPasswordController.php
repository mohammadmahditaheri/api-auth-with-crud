<?php

namespace Modules\Auth\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\Response;
use Modules\Auth\Contracts\Actions\SendResetSecretHandlerInterface;
use Modules\Auth\Contracts\Repositories\ResetPasswordRepoInterface;
use Modules\Auth\Traits\Responses\FormatsResetResponses;

class ResetPasswordController extends Controller
{
    use FormatsResetResponses;

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
        //
    }
}
