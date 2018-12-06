<?php

namespace Laravel\Nova\Tests\Controller;

use Laravel\Nova\Tests\Fixtures\User;
use Laravel\Nova\Tests\IntegrationTest;
use Laravel\Nova\Tests\Fixtures\Address;

class ResourceFilledCallbackTest extends IntegrationTest
{
    public function setUp()
    {
        parent::setUp();

        $this->authenticate();
    }

    public function test_can_create_resources_that_have_belongs_to_fields_with_filled_callbacks()
    {
        // This is primarily useful for filling in belongs-to fields that can be dervived from other fields
        // For example, deriving the server_id from a selected site...
        $user = $this->createUser();

        $response = $this->withExceptionHandling()
                        ->postJson('/nova-api/addresses', [
                            'user' => $user->id,
                        ]);

        $response->assertStatus(201);

        $address = Address::first();
        $this->assertEquals('Filled Name', $address->name);
        $this->assertEquals($user->id, $address->user_id);
    }
}
