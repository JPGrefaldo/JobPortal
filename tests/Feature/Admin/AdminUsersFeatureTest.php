<?php

namespace Tests\Feature\Admin;

use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminUsersFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /** @test */
    public function ban()
    {
        $admin = $this->createAdmin();
        $user  = $this->createUser();
        $data  = ['reason' => 'some reason'];

        $response = $this->actingAs($admin)->put('admin/users/ban/' . $user->id, $data);

        // assert user has been banned
        $user->refresh();

        $this->assertArraySubset(
            [
                'user_id' => $user->id,
                'reason' => 'some reason'
            ],
            $user->banned->toArray()
        );

        $this->assertFalse($user->isActive());

        $response->assertSuccessful();
    }

    /** @test */
    public function ban_user_not_exist()
    {
        $admin = $this->createAdmin();
        $data  = ['reason' => 'some reason'];

        $response = $this->actingAs($admin)->put('admin/users/ban/44');

        $response->assertNotFound();
    }

    /** @test */
    public function ban_invalid_data()
    {
        $admin = $this->createAdmin();
        $user  = $this->createUser();
        $data  = ['reason' => ''];

        $response = $this->actingAs($admin)->put('admin/users/ban/' . $user->id, $data);

        $response->assertSessionHasErrors([
            'reason' => 'The reason field is required.',
        ]);
    }

    /** @test */
    public function ban_unauthorized()
    {
        $crew = $this->createCrewUser();
        $user = $this->createUser();

        $response = $this->actingAs($crew)->put('admin/users/ban/' . $user->id);

        $response->assertRedirect('/');
    }
}
