<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Modules\Auth\Contracts\Repositories\UserRepositoryInterface;
use Modules\Auth\Contracts\Services\MailSecretHandler\MailHandlerInterface;
use Modules\Auth\Traits\Responses\FormatsAuthResponses;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use FormatsAuthResponses;

    protected array $userData = [];
    public static string $requiredErrorMessage = 'The email field is required.';
    public static string $invalidEmailError = 'The email field must be a valid email address.';
    public static string $notStringError = 'The email field must be a string.';

    /**
     * @var UserRepositoryInterface $repository
     */
    protected UserRepositoryInterface $repository;
    const TABLE = 'users';

    public function setUp(): void
    {
        parent::setUp();

        // user data
        $this->userData = [
            'first_name' => 'Mohammad Mahdi',
            'last_name' => 'Taheri',
            'email' => 'mmtaheri@gmail.com',
        ];

        // init the repository
        $this->repository = resolve(UserRepositoryInterface::class);
    }

    /**
     * do send the register request with email
     *
     * @param string|null $email
     * @return TestResponse
     */
    protected function sendRegisterRequest(string $email = null): TestResponse
    {
        if (!$email) {
            $email = $this->userData['email'];
        }

        return $this->postJson(route('register'),
            ['email' => $email]
        );
    }

    /**
     * |--------------------
     * | Tests begin
     * |--------------------
     */

    /**
     * @test
     */
    public function it_can_register_with_email_and_set_secret(): void
    {
        $response = $this->sendRegisterRequest();

        // response
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => self::$mailedMessage
            ]);

        // database
        $this->assertDatabaseCount(self::TABLE, 1);
        $this->assertDatabaseHas(self::TABLE, [
            'email' => $this->userData['email']
        ]);
    }

    /**
     * @test
     */
    public function it_cannot_register_with_same_email_twice(): void
    {
        $response = $this->sendRegisterRequest();

        // response
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => self::$mailedMessage
            ]);

        // database
        $secret = $this->repository->findByEmail($this->userData['email'])->two_factor_secret;

        // send again
        $secondResponse = $this->sendRegisterRequest();

        // second response should be the same as first
        $secondResponse->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => self::$mailedMessage
            ]);

        // secret should not be changed
        $this->assertEquals($this->repository->findByEmail($this->userData['email'])->two_factor_secret, $secret);
    }

    /**
     * @test
     */
    public function it_cannot_register_without_email(): void
    {
        $response = $this->postJson(route('register'),
            ['email' => null]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => self::$requiredErrorMessage,
                'errors' => [
                    'email' => [self::$requiredErrorMessage]
                ]
            ]);
    }

    /**
     * @test
     */
    public function it_cannot_register_wit_invalid_email(): void
    {
        // send email as not string
        $response = $this->postJson(route('register'),
            ['email' => 123]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => self::$notStringError . ' (and 1 more error)',
                'errors' => [
                    'email' => [
                        self::$notStringError,
                        self::$invalidEmailError
                    ]
                ]
            ]);

        // send email as invalid string
        $response = $this->postJson(route('register'),
            ['email' => '123']
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => self::$invalidEmailError,
                'errors' => [
                    'email' => [
                        self::$invalidEmailError
                    ]
                ]
            ]);
    }
}
