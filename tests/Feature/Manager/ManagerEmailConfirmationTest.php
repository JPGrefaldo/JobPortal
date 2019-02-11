<?php

namespace Test\Feature\Manager;

use App\Models\User;
use App\Models\Manager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ManagerEmailConfirmationTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountManagerController::index
     */

    public function will_not_update_status_twice()
    {
       $manager = $this->createUser();
       $subordinate = $this->createUser();
       
       $this->actingAs($subordinate)
            ->get(route('account.manager'));

       $response = $this->actingAs($subordinate)
                        ->post(route('account.manager'), [
                            'email' => $manager->email
                        ]);

       $response->assertRedirect(route('account.manager'));

       $this->get('/confirm/' . $manager->hash_id . '/'. $subordinate->hash_id);
       $response = $this->get('/confirm/' . $manager->hash_id . '/'. $subordinate->hash_id);

       $response->assertRedirect(route('login'));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountManagerController::index
     */

     public function update_manager_status()
     {
        $manager = $this->createUser();
        $subordinate = $this->createUser();
        
        $this->actingAs($subordinate)
             ->get(route('account.manager'));

        $response = $this->actingAs($subordinate)
                         ->post(route('account.manager'), [
                             'email' => $manager->email
                         ]);

        $response->assertRedirect(route('account.manager'));

        $this->get('/confirm/' . $manager->hash_id . '/'. $subordinate->hash_id);

        $this->assertDatabaseHas('managers', [
                'manager_id' => $manager->id,
                'subordinate_id' => $subordinate->id,
                'status' => 1
            ]
        );
     }
}