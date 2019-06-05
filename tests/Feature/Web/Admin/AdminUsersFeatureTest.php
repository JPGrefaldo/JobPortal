<?php

namespace Tests\Feature\Web\Admin;
;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class AdminUsersFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\AdminUserController::updateBan
     */
    public function ban()
    {
        $admin = $this->createAdmin();
        $user = $this->createUser();
        $data = [
            'reason' => 'some reason',
        ];

        $response = $this->actingAs($admin)
            ->put(route('admin.users.ban', $user), $data);

        $user->refresh();

        $this->assertArrayHas(
            [
                'user_id' => $user->id,
                'reason'  => 'some reason',
            ],
            $user->banned->toArray()
        );

        $this->assertFalse($user->isActive());

        $response->assertSuccessful();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\AdminUserController::updateBan
     */
    public function ban_user_not_exist()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)
            ->put(route('admin.users.ban', [
                'user',
                44,
            ]));

        $response->assertNotFound();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\AdminUserController::updateBan
     */
    public function ban_invalid_data()
    {
        $admin = $this->createAdmin();
        $user = $this->createUser();
        $data = [
            'reason' => '',
        ];

        $response = $this->actingAs($admin)
            ->put(route('admin.users.ban', $user), $data);

        $response->assertSessionHasErrors([
            'reason' => 'The reason field is required.',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\AdminUserController::updateBan
     */
    public function ban_unauthorized()
    {
        $crew = $this->createCrew();
        $user = $this->createUser();

        $response = $this->actingAs($crew)
            ->put(route('admin.users.ban', $user));

        $response->assertForbidden();
    }
}
