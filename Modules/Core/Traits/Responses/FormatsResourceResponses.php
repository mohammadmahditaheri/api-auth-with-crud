<?php

namespace Modules\Core\Traits\Responses;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

trait FormatsResourceResponses
{
    /**
     * formats generic success response with message
     *  and status code for non-paginated data.
     *
     */
    protected function singleResourceResponse(
        $data,
        string $message = null,
        $apiResource = null,
        $code = SymfonyResponse::HTTP_OK,
    ): Response
    {
        $response = [
            'data' => ($apiResource == null)
                ? $data
                : new $apiResource($data)
        ];

        // append message
        if ($message !== null) {
            $response = array(
                    'message' => $message
                ) + $response;
        }

        return response($response, $code);
    }

    /**
     * formats a success response with paginated data
     * and status code
     */
    protected function paginatedResourcesResponse(
        $data,
        $apiResource,
        $code = SymfonyResponse::HTTP_OK,
    ): Response
    {
        return response(
            $apiResource::collection($data)
                ->response()
                ->getData(true),
            $code
        );
    }
}
