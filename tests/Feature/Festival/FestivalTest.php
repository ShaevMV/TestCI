<?php

namespace Tests\Feature\Festival;

use App\User;
use Tests\TestCase;

class FestivalTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = User::first();
        if (null !== $user) {
            $response = $this->actingAs($user, 'api')
                ->post('/api/v1/festival/getList/1/12', []);

            $response->assertOk();
            $result = json_decode((string)$response->content(), true);

            $this->assertArrayHasKey('items', $result);
            $this->assertArrayHasKey('columns', $result['items']);
            $this->assertArrayHasKey('rows', $result['items']);

            $this->assertArrayHasKey('pagination', $result);
            $this->assertArrayHasKey('page', $result['pagination']);
            $this->assertArrayHasKey('limit', $result['pagination']);
            $this->assertArrayHasKey('total', $result['pagination']);
        }
    }
}
