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
     * @covers \App\Http\Controllers\Account\AccountManagerController::index
     */
    public function show_manager_email()
    {
        $subordinate = $this->createUser();
        $manager = $this->createUser([
                        'email' => 'manager@email.com'
                   ]);

        $this->actingAs($subordinate)
             ->get(route('account.manager'));

        $response = $this->actingAs($subordinate)
                         ->post(route('account.manager'), [
                             'email' => $manager->email
                         ]);

        $response->assertRedirect(route('account.manager'));

        $this->assertEquals('manager@email.com', $manager->email);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountManagerController::store
     */
    public function cannot_add_manager_using_unregistered_email()
    {
        $subordinate = $this->createUser();
        $manager = [
            'email' => 'manager@email.com'
        ];

       $this->actingAs($subordinate)
             ->get(route('account.manager'));

        $response = $this->actingAs($subordinate)
                         ->post(route('account.manager'), $manager);

        $response->assertRedirect(route('account.manager'));

        $response->assertSessionHasErrors('unregistered_email');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountManagerController::store
     */
    public function cannot_add_manager_using_own_email()
    {
        $user = $this->createUser();

        $this->actingAs($user)
             ->get(route('account.manager'));

        $response = $this->actingAs($user)
                         ->post(route('account.manager'), [
                             'email' => $user->email
                         ]);

        $response->assertRedirect(route('account.manager'));

        $response->assertSessionHasErrors('own_email');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountManagerController::store
     */
    public function user_can_add_manager()
    {
        $subordinate = $this->createUser();
        $manager = $this->createUser([
                        'email' => 'manager@email.com'
                   ]);

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

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountManagerController::store
     */
    public function user_can_update_manager()
    {
        $subordinate = $this->createUser();
        $manager = $this->createUser([
                        'email' => 'manager@email.com'
                   ]);
        $manager2 = $this->createUser([
                            'email' => 'manager2@email.com'
                    ]);

        $this->actingAs($subordinate)
             ->get(route('account.manager'));

        $response = $this->actingAs($subordinate)
                         ->post(route('account.manager'), [
                             'email' => $manager->email
                         ]);

        $response->assertRedirect(route('account.manager'));

        $response = $this->actingAs($subordinate)
                         ->post(route('account.manager'), [
                             'email' => $manager2->email
                         ]);

        $this->assertContains([
            'manager_id' => 3
        ],
            $manager->refresh()
                    ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountManagerController::destroy
     */
    public function user_can_remove_manager()
    {
        $subordinate = $this->createUser();
        $manager = $this->createUser([
                        'email' => 'manager@email.com'
                   ]);

        $this->actingAs($subordinate)
             ->get(route('account.manager'));

        $this->actingAs($subordinate)
             ->post(route('account.manager'), [
                'email' => $manager->email
             ]);

        $this->actingAs($subordinate)
             ->call('DELETE', '/account/manager/remove/'.$manager->id, [
                 '_token' => csrf_token()
             ]);

        $this->assertDatabaseMissing('managers', 
                    $manager->refresh()
                            ->toArray()
                );
    }
}