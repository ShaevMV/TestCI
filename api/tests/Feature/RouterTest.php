<?php

namespace Tests\Feature;

use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Class ExampleTest
 * @package Tests\Feature
 *
 * + Добавить проверку открытие admin
 */
class RouterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Добавить проверку открытие admin
     *
     * @return void
     */
    public function testBasicAdminTest()
    {
        Passport::actingAs(
            User::first(),
            ['create-servers']
        );

        $response = $this->get('/admin');

        $response->assertStatus(200);
    }
}
