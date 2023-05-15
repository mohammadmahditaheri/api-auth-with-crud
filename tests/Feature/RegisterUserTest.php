<?php

namespace Tests\Feature;

use Illuminate\Testing\TestResponse;
use Modules\Auth\Contracts\Repositories\UserRepositoryInterface;
use Modules\Auth\Traits\Responses\FormatsAuthResponses;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthTestCase as TestCase;

class RegisterUserTest extends TestCase
{
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
    public function it_cannot_register_with_invalid_email(): void
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

    /**
     * @test
     */
    public function it_cannot_register_without_post_method(): void
    {
        // GET
        $response = $this->getJson(route('register'),
            ['email' => $this->userData['email']]
        );
        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);

        // PUT
        $response = $this->putJson(route('register'),
            ['email' => $this->userData['email']]
        );
        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);

        // PATCH
        $response = $this->patchJson(route('register'),
            ['email' => $this->userData['email']]
        );
        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);

        // DELETE
        $response = $this->deleteJson(route('register'),
            ['email' => $this->userData['email']]
        );
        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);

        // DELETE
        $response = $this->head(route('register'),
            ['email' => $this->userData['email']]
        );
        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
