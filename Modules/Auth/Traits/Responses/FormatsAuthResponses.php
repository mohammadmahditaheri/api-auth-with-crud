<?php

namespace Modules\Auth\Traits\Responses;

use Illuminate\Http\Response;

trait FormatsAuthResponses
{
    use FormatsSuccessResponses;

    public static string $mailedMessage = 'We just sent you an email containing the secret code. Please check your email.';

    public function secretMailedSuccessfully(): Response
    {
        return $this->successfulResponse(
            message: self::$mailedMessage,
            code: Response::HTTP_CREATED
        );
    }
}
