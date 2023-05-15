<?php

namespace Modules\Auth\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\ArrayShape;
use Modules\Auth\Contracts\Repositories\UserRepositoryInterface;
use Modules\Auth\Http\Requests\FinalizeRegisterRequest;
use Modules\Auth\Traits\Responses\FormatsAuthResponses;
use Modules\Auth\Traits\Responses\FormatsAuthErrorResponses;

class FinalizeRegisterController extends Controller
{
    use FormatsAuthResponses,
        FormatsAuthErrorResponses;

    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    /**
     * Fulfill the registration process.
     */
    public function __invoke(FinalizeRegisterRequest $request): Response
    {
        $user = $this->repository->findByEmail($request->validated('email'));

        // finalize the registration
        $result = $this->repository->update(
            $user,
            $this->assembleFields($request)
        );

        return $result
            ? $this->registeredSuccessfully()
            : $this->registrationFailed();
    }

    /**
     * assemble the updating fields for user
     */
    #[ArrayShape(['first_name' => "string", 'last_name' => "string", 'password' => "string"])]
    private function assembleFields(FormRequest $request): array
    {
        return [
            'first_name' => $request->validated('first_name'),
            'last_name' => $request->validated('last_name'),
            'password' => bcrypt($request->validated('password')),
        ];
    }
}
