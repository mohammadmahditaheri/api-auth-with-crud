<?php

namespace Modules\Auth\Traits\Responses;

use Illuminate\Http\Response;
use Modules\Auth\Http\Resources\UserResource;
use Modules\Auth\Models\User;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

trait FormatsLoginResponse
{
    public function loggedInSuccessfully(User $user, string $token): Response
    {
        return response([
            'user' => new UserResource($user),
            'token' => $token
        ], SymfonyResponse::HTTP_OK);
    }
}
