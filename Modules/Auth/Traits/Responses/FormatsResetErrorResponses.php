<?php

namespace Modules\Auth\Traits\Responses;

use Modules\Core\Traits\Responses\FormatsErrorResponses;

trait FormatsResetErrorResponses
{
    use FormatsErrorResponses;

    public static string $resetFailedMessage = 'Resetting password failed.';

    public function resetFailed()
    {
        throw $this->errorResponse(
            message: self::$resetFailedMessage
        );
    }
}
