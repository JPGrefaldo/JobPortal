<?php

namespace Tests\Feature\Manager;

use App\Models\User;
use App\Models\Manager;
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
        $subordinate = $this->createUser();
        $manager = $this->createUser([
                        'email' => 'manager@email.com'
                   ]) ;

        $this->actingAs($subordinate)
             ->get(route('account.manager'));

        $response = $this->actingAs($subordinate)
                         ->post(route('account.manager'), [
                             'email' => $manager->email
                         ]);

        $response->assertRedirect(route('account.manager'));

        $this->assertContains([
            'manager_id' => 2
        ],
            $manager->refresh()
                    ->toArray()
        );
    }
}