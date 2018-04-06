<?php

namespace Tests\Unit\Services;

use App\Role;
use App\Services\AuthServices;
use App\User;
use App\Utils\UrlUtils;
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
        $site = $this->getCurrentSite();

        $this->service->createCrew($user, $site);

        $this->assertTrue($user->hasRole(Role::CREW));
        $this->assertTrue($user->hasSite($site->hostname));
    }
}
