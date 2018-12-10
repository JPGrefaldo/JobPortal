<?php

namespace Tests\Feature\Middleware;

use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorizeRolesTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;

    /** @test */
    public function web_authorize_crew()
    {
        $user = $this->createCrew();

        $response = $this->actingAs($user)->get('test/rolescrew');

        $response->assertSuccessful();
    }

    /** @test */
    public function web_unauthorize_not_crew()
    {
        $user = $this->createProducer();

        $response = $this->actingAs($user)->get('test/rolescrew');

        $response->assertRedirect('/');
    }

    /** @test */
    public function web_authorize_admin_always()
    {
        $user = $this->createAdmin();

        $response = $this->actingAs($user)->get('test/rolescrew');

        $response->assertSuccessful();
    }

    /** @test */
    public function web_authorize_admin_only()
    {
        $user = $this->createAdmin();

        $response = $this->actingAs($user)->get('test/rolesadmin');

        $response->assertSuccessful();
    }

    /** @test */
    public function web_unauthorize_non_admin()
    {
        $user = $this->createCrew();

        $response = $this->actingAs($user)->get('test/rolesadmin');

        $response->assertRedirect('/');
    }

    /** @test */
    public function api_authorize_crew()
    {
        $user = $this->createCrew();

        $response = $this->actingAs($user, 'api')->get('api/test/rolescrew');

        $response->assertSuccessful();
    }

    /** @test */
    public function api_unauthorize_not_crew()
    {
        $user = $this->createProducer();

        $response = $this->actingAs($user, 'api')->get('api/test/rolescrew');

        $response->assertStatus(401);
    }

    /** @test */
    public function api_authorize_admin_always()
    {
        $user = $this->createAdmin();

        $response = $this->actingAs($user, 'api')->get('api/test/rolescrew');

        $response->assertSuccessful();
    }

    /** @test */
    public function api_authorize_admin_only()
    {
        $user = $this->createAdmin();

        $response = $this->actingAs($user, 'api')->get('api/test/rolesadmin');

        $response->assertSuccessful();
    }

    /** @test */
    public function api_unauthorize_non_admin()
    {
        $user = $this->createCrew();

        $response = $this->actingAs($user, 'api')->get('api/test/rolesadmin');

        $response->assertStatus(401);
    }

    /** @test */
    public function api_authorize_crew_producer_crew()
    {
        $user = $this->createCrew();

        $response = $this->actingAs($user, 'api')->get('api/test/rolescrewproducer');

        $response->assertSuccessful();
    }

    /** @test */
    public function api_authorize_crew_producer_producer()
    {
        $user = $this->createProducer();

        $response = $this->actingAs($user, 'api')->get('api/test/rolescrewproducer');

        $response->assertSuccessful();
    }
}
