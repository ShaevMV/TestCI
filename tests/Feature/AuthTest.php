<?php

namespace Tests\Feature;

use App\Ticket\Modules\Auth\Repository\OathClientsRepository;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private OathClientsRepository $oathClientsRepository;

    /**
     * A basic feature test example.
     *
     * @return void
     * @throws GuzzleException
     */
    public function testExample()
    {
        $urlOauthToken = env('APP_URL_DOCKER', 'http://172.18.0.4:8083/') . 'api/auth/login';
        $http = new Client();
        /** @var User $user */
        $user = User::first();
        $response = $http->post($urlOauthToken, [
            'form_params' => [
                'email' => $user->email,
                'password' => 'secret',
            ],
        ]);
        $result = json_decode((string)$response->getBody(), true);

        $this->assertArrayHasKey('token_type', $result);
        $this->assertArrayHasKey('expires_in', $result);
        $this->assertArrayHasKey('access_token', $result);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->oathClientsRepository = $this->app->get(OathClientsRepository::class);
    }
}
