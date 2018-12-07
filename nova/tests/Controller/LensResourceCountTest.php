<?php

namespace Laravel\Nova\Tests\Controller;

use Laravel\Nova\Nova;
use Laravel\Nova\Tests\Fixtures\User;
use Laravel\Nova\Tests\IntegrationTest;
use Laravel\Nova\Tests\Fixtures\IdFilter;

class LensResourceCountTest extends IntegrationTest
{
    public function setUp()
    {
        parent::setUp();

        $this->authenticate();
    }

    public function test_can_count_a_resource()
    {
        $this->createUser();
        $this->createUser();
        $this->createUser();

        $response = $this->withExceptionHandling()
                        ->getJson('/nova-api/users/lens/user-lens/count');

        $response->assertStatus(200);
        $this->assertEquals(3, $response->original['count']);
    }

    public function test_can_count_a_resource_via_filter()
    {
        $this->createUser();
        $this->createUser();
        $this->createUser();

        $filters = base64_encode(json_encode([
            [
                'class' => IdFilter::class,
                'value' => 2,
            ],
        ]));

        $response = $this->withExceptionHandling()
                        ->getJson('/nova-api/users/lens/user-lens/count?filters='.$filters);

        $response->assertStatus(200);
        $this->assertEquals(1, $response->original['count']);
    }
}
