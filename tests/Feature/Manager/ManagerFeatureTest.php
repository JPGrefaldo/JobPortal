<?php

namespace Tests\Feature\Manager;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ManagerFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountManagerController::store
     */
    public function user_can_add_manager()
    {
        $user = $this->createUser();
        $email = ["manager@email.com"];

        $this->actingAs($user)
             ->get(route('account.manager'));

        $response = $this->actingAs($user)
                         ->post(route('account.manager'), $email)
                         ->assertStatus(200);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountManagerController::store
     */
    public function user_can_edit_manager()
    {
        
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountManagerController::destroy
     */
    public function user_can_delete_manager()
    {
        
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountManagerController::destroy
     */
    public function manager_will_be_deleted_when_user_is_deleted()
    {
        
    }

}