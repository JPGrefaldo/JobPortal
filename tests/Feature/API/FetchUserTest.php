<?php

namespace Tests\Feature\API;

use App\Models\User;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FetchUserTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;

    const URI = 'api/user';

    /**
     * @test
     * @covers
     */
    public function user()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user, 'api')->getJson(self::URI);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'id',
                'first_name',
                'last_name'
            ]);
    }

    /**
     * @test
     * @covers
     */
    public function unauthorized_guest()
    {
        $response = $this->getJson(self::URI);

        $response->assertStatus(401);
    }
}
