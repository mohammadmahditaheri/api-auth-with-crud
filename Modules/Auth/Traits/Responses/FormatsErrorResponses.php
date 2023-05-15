<?php

namespace Modules\Auth\Traits\Responses;

use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

trait FormatsErrorResponses
{
    /**
     * formats successful response with proper message and status code
     *
     * @param string $message
     * @param int $code
     * @throws HttpResponseException
     */
    public function errorResponse(
        string $message,
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        throw new HttpResponseException(
            response([
                'message' => $message
            ], $code)
        );
    }
}
