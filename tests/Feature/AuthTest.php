<?php

namespace Tests\Feature;

use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * @throws GuzzleException
     */
    public function testExample()
    {
        $urlOauthToken = env('APP_URL_DOCKER', '') . 'oauth/token';

        $http = new Client();
        $clientId = env('MIX_CLIENT_ID', false);
        $clientSecret = env('MIX_PUSHER_APP_KEY_API', false);
        $user = User::first();
        $response = $http->post($urlOauthToken, [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
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
}
