<?php

namespace Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Testing\TestResponse;
use Modules\Auth\Contracts\Repositories\UserRepositoryInterface;
use Modules\Auth\Traits\Responses\FormatsAuthResponses;

abstract class AuthTestCase extends TestCase
{
    use FormatsAuthResponses;

    const FINALIZE_ROUTE = 'finalize-register';
    const REGISTER_ROUTE = 'register';
    const LOGIN_ROUTE = 'login';
    const TABLE = 'users';
    protected array $userData = [];
    public static string $requiredErrorMessage = 'The email field is required.';
    public static string $invalidEmailError = 'The email field must be a valid email address.';
    public static string $notStringError = 'The email field must be a string.';

    /**
     * @var UserRepositoryInterface $repository
     */
    protected UserRepositoryInterface $repository;

    public function setUp(): void
    {
        parent::setUp();

        // user data
        $this->userData = [
            'first_name' => 'Mohammad Mahdi',
            'last_name' => 'Taheri',
            'email' => 'mmtaheri@gmail.com',
            'password' => 'password'
        ];

        // init the repository
        $this->repository = resolve(UserRepositoryInterface::class);
    }

    /**
     * send register request
     *
     * @param string|null $email
     * @return TestResponse
     */
    protected function sendRegisterRequest(string $email = null): TestResponse
    {
        if (!$email) {
            $email = $this->userData['email'];
        }

        return $this->postJson(route(self::REGISTER_ROUTE),
            ['email' => $email]
        );
    }

    /**
     * send finalize register request
     *
     * @param string|null $secret
     * @param string|null $email
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $password
     * @param string|null $passwordConfirmation
     * @return TestResponse
     */
    protected function sendFinalizeRequest(
        string|null $secret = null,
        string|null $email = null,
        string|null $firstName = null,
        string|null $lastName = null,
        string|null $password = null,
        string|null $passwordConfirmation = null
    ): TestResponse
    {
        return $this->postJson(route(self::FINALIZE_ROUTE, [
            'secret' => $secret,
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation
        ]));
    }

    /**
     * send finalize register request with default data
     *
     * @param string $secret
     * @return TestResponse
     */
    protected function sendFinalizeAsDefault(string $secret): TestResponse
    {
        return $this->sendFinalizeRequest(
            secret: $secret,
            email: $this->userData['email'],
            firstName: $this->userData['first_name'],
            lastName: $this->userData['last_name'],
            password: $this->userData['password'],
            passwordConfirmation: $this->userData['password']
        );
    }

    /**
     * fetch secret for email
     *
     * @param string $email
     * @return mixed
     */
    protected function fetchSecret(string $email): mixed
    {
        return DB::table(self::TABLE)
            ->select('two_factor_secret')
            ->where('email', $email)
            ->first()->two_factor_secret;
    }
}
