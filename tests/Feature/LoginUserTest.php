<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Tests\AuthTestCase as TestCase;

class LoginUserTest extends TestCase
{
    /**
     * send login request with credentials
     *
     * @param string $email
     * @param string $password
     * @return TestResponse
     */
    protected function postLogin(string $email, string $password): TestResponse
    {
        return $this->postJson(route(self::LOGIN_ROUTE, [
            'email' => $email,
            'password' => $password
        ]));
    }

    /**
     * @test
     */
    public function it_can_login_with_default_data(): void
    {
        // send register request
        $registerResponse = $this->sendRegisterRequest();

        // first response assertion
        $registerResponse->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => self::$mailedMessage
            ]);

        // check database
        $this->assertDatabaseCount(self::TABLE, 1);
        $this->assertDatabaseHas(self::TABLE, [
            'email' => $this->userData['email']
        ]);

        // fetch secret
        $secret = $this->fetchSecret($this->userData['email']);

        // send finalize request
        $response = $this->sendFinalizeAsDefault($secret);

        $response->assertStatus(SymfonyResponse::HTTP_OK)
            ->assertJson([
                'message' => self::$registeredMessage
            ]);

        // send login request
        $response = $this->postLogin(
            email: $this->userData['email'],
            password: $this->userData['password']
        );

        $response->assertOk()
            ->assertJsonStructure([
                'user', 'token'
            ]);
    }
}
