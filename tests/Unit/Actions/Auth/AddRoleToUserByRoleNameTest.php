<?php

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\AddRoleToUserByRoleName;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class AddRoleToUserByRoleNameTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var AddRoleToUserByRoleName
     */
    public $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(AddRoleToUserByRoleName::class);
    }

    /**
     * @test
     * @covers \App\Actions\Auth\AddRoleToUserByRoleName::execute
     */
    public function execute()
    {
        $user = $this->createUser();

        $this->service->execute($user, Role::PRODUCER);

        $this->assertDatabaseHas('user_roles', [
            'user_id' => $user->id,
        ]);
    }
}
