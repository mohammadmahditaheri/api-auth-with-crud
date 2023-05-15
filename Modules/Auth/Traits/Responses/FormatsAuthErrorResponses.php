<?php

namespace Modules\Auth\Traits\Responses;

trait FormatsAuthErrorResponses
{
    use FormatsErrorResponses;

    public static string $registrationFailedMessage = 'The registration operation failed.';
    public static string $finalizeFailedMessage = 'The provided credentials don\'t match';

    public function registrationFailed()
    {
        throw $this->errorResponse(
            message: self::$registrationFailedMessage
        );
    }

    public function finalizeRegistrationFailed()
    {
        throw $this->errorResponse(
            message: self::$finalizeFailedMessage
        );
    }
}
