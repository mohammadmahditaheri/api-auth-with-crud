<?php

namespace Modules\Auth\Traits\Responses;

use Illuminate\Http\Response;
use Modules\Core\Traits\Responses\FormatsSuccessResponses;

trait FormatsResetResponses
{
    use FormatsSuccessResponses;

    public static string $resetSecretSentMessage = 'A secret code has been sent to the provided email address. please check you email.';
    public static string $resetPasswordIsSuccessfulMessage = 'Your password has been changed successfully.';

    public function resetSecretSent(): Response
    {
        return $this->successfulResponse(
            message: self::$resetSecretSentMessage
        );
    }

    public function resetPasswordIsSuccessful(): Response
    {
        return $this->successfulResponse(
            message: self::$resetPasswordIsSuccessfulMessage
        );
    }
}
