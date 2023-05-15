<?php

namespace Modules\Auth\Traits\Responses;

trait FormatsAuthErrorResponses
{
    use FormatsErrorResponses;

    public static string $registrationFailedMessage = 'The registration operation failed.';

    public function registrationFailed()
    {
        throw $this->errorResponse(
            message: self::$registrationFailedMessage
        );
    }
}
