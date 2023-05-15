<?php

namespace Modules\Auth\Traits\Responses;

use Illuminate\Http\Response;
use Modules\Core\Traits\Responses\FormatsSuccessResponses;

trait FormatsAuthResponses
{
    use FormatsSuccessResponses;

    public static string $mailedMessage = 'We just sent you an email containing the secret code. Please check your email.';
    public static string $registeredMessage = 'The registration is completed successfully.';

    public function secretMailedSuccessfully(): Response
    {
        return $this->successfulResponse(
            message: self::$mailedMessage,
            code: Response::HTTP_CREATED
        );
    }

    public function registeredSuccessfully(): Response
    {
        return $this->successfulResponse(
            message: self::$registeredMessage
        );
    }
}
