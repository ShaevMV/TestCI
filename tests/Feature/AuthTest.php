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
        $urlOauthToken = env('APP_URL_DOCKER', 'http://172.18.0.5:8083/') . 'oauth/token';
        $accessToken = $this->oathClientsRepository->getApiAccessToken();
        $http = new Client();
        $user = User::first();
        $response = $http->post($urlOauthToken, [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $accessToken->getClientId(),
                'client_secret' => $accessToken->getPasswordKey(),
                'username' => $user->email,
                'password' => 'secret',
                'scope' => '*',
            ],
        ]);
        $result = json_decode((string)$response->getBody(), true);

        $this->assertArrayHasKey('token_type', $result);
        $this->assertArrayHasKey('expires_in', $result);
        $this->assertArrayHasKey('access_token', $result);
        $this->assertArrayHasKey('refresh_token', $result);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->oathClientsRepository = $this->app->get(OathClientsRepository::class);
    }
}
