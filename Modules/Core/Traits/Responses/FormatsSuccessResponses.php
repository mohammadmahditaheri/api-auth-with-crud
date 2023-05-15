<?php

namespace Modules\Core\Traits\Responses;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use function response;

trait FormatsSuccessResponses
{
    /**
     * formats successful response with proper message and status code
     *
     * @param string $message
     * @param int $code
     * @return Response
     */
    protected function successfulResponse(
        string $message,
        int $code = SymfonyResponse::HTTP_OK,
    ): Response
    {
        return response([
            'message' => $message
        ], $code);
    }
}
