<?php

namespace Tests\Unit\Services;

use App\Role;
use App\Services\AuthServices;
use App\User;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthServicesTest extends TestCase
{
    /**
     * @var AuthServices
     */
    protected $service;

    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(AuthServices::class);
    }

    /** @test */
    public function create_crew()
    {
        $user = factory(User::class)->create();

        $this->service->createCrew($user);

        $this->assertTrue($user->hasRole(Role::CREW));
    }
}
