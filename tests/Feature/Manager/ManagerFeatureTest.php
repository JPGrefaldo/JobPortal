<?php

namespace Tests\Feature\Manager;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ManagerFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp()
    {
        $this->user = $this->createUser();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountManagerController::store
     */
    public function user_can_add_manager()
    {
        
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