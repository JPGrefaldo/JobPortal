<?php

namespace Tests\Unit\Services;

use App\Models\Role;
use App\Services\AuthServices;
use App\Models\User;
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
    public function create_by_role_name()
    {
        $user = factory(User::class)->create();
        $site = $this->getCurrentSite();

        $this->service->createByRoleName(Role::CREW, $user, $site);

        $this->assertTrue($user->hasRole(Role::CREW));
        $this->assertTrue($user->hasSite($site->hostname));
        $this->assertNotEmpty($user->emailVerificationCode->code);
    }
}
