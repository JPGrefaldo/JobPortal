<?php

namespace Tests\Feature\User;

use App\Models\UserNotificationSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class UserAccountFeatureTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountNameController::store
     */
    public function update_name()
    {
        $user = $this->createUser();
        $data = [
            'first_name' => 'Adam James',
            'last_name'  => 'Ford',
            'nickname'   => 'The Rock',
        ];

        $this->actingAs($user)
            ->get(route('account.name'));

        $response = $this->actingAs($user)
            ->post(route('account.name'), $data);

        $response->assertRedirect(route('account.name'));

        $this->assertArrayHas(
            [
                'first_name' => 'Adam James',
                'last_name'  => 'Ford',
                'nickname'   => 'The Rock',
            ],
            $user->refresh()
                ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountNameController::store
     */
    public function update_name_needs_reformat()
    {
        $user = $this->createUser();
        $data = [
            'first_name' => 'JoHn jAMES',
            'last_name'  => "O'neal",
            'nickname'   => '',
        ];

        $this->actingAs($user)
            ->get(route('account.name'));

        $response = $this->actingAs($user)
            ->post(route('account.name'), $data);

        $response->assertRedirect(route('account.name'));

        $this->assertArrayHas(
            [
                'first_name' => 'John James',
                'last_name'  => "O'Neal",
                'nickname'   => '',
            ],
            $user->refresh()
                ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountNameController::store
     */
    public function update_name_invalid_data()
    {
        $user = $this->createUser();
        $data = [
            'first_name' => '123 Robot',
            'last_name'  => '2543',
        ];

        $this->actingAs($user)
            ->get(route('account.name'));

        $response = $this->actingAs($user)
            ->post(route('account.name'), $data);

        $response->assertSessionHasErrors([
            'first_name',
            // a-z'- and space chars are only allowed
            'last_name',
            // a-z- and space chars are only allowed
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountContactController::store
     */
    public function update_contact()
    {
        $user = $this->createUser();
        $emailAddress = 'test@test.com';

        $data = [
            'email'              => $emailAddress,
            'email_confirmation' => $emailAddress,
            'phone'              => '5555555555',
        ];

        $this->actingAs($user)
            ->get(route('account.contact'));

        $response = $this->actingAs($user)
            ->post(route('account.contact'), $data);

        $response->assertRedirect(route('account.contact'));

        $this->assertArrayHas(
            [
                'email' => $emailAddress,
                'phone' => '5555555555',
            ],
            $user->refresh()
                ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountContactController::store
     */
    public function update_contact_no_email_confirmation()
    {
        $user = $this->createUser();
        $emailAddress = 'test@test.com';

        $data = [
            'email' => $emailAddress,
            'phone' => '5555555555',
        ];

        $this->actingAs($user)
            ->get(route('account.contact'));

        $response = $this->actingAs($user)
            ->post(route('account.contact'), $data);

        $response->assertRedirect(route('account.contact'));

        $response->assertSessionHasErrors([
            'email',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountContactController::store
     */
    public function update_contact_bad_email_address()
    {
        $user = $this->createUser();
        $emailAddress = 'no email!';

        $data = [
            'email'              => $emailAddress,
            'email_confirmation' => $emailAddress,
            'phone'              => '5555555555',
        ];

        $this->actingAs($user)
            ->get(route('account.contact'));

        $response = $this->actingAs($user)
            ->post(route('account.contact'), $data);

        $response->assertRedirect(route('account.contact'));

        $response->assertSessionHasErrors([
            'email',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountContactController::store
     */
    public function update_contact_phone_number()
    {
        $user = $this->createUser();
        $emailAddress = 'test@test.com';

        $data = [
            'email'              => $emailAddress,
            'email_confirmation' => $emailAddress,
            'phone'              => '55553555555',
        ];

        $this->actingAs($user)
            ->get(route('account.contact'));

        $response = $this->actingAs($user)
            ->post(route('account.contact'), $data);

        $response->assertRedirect(route('account.contact'));

        $response->assertSessionHasErrors([
            'phone',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountPasswordController::store
     */
    public function update_password()
    {
        $user = $this->createUser(['password' => Hash::make('current_password')]);
        $data = [
            'current_password'      => 'current_password',
            'password'              => 'new_password',
            'password_confirmation' => 'new_password',
        ];

        Hash::shouldReceive('make')
            ->once()
            ->andReturn('hashed_new_password');
        Hash::makePartial();

        $this->actingAs($user)
            ->get(route('account.password'));

        $response = $this->actingAs($user)
            ->post(route('account.password'), $data);

        $response->assertRedirect(route('account.password'));

        $user->refresh();

        $this->assertEquals('hashed_new_password', $user->password);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountPasswordController::store
     */
    public function update_password_no_confirmation()
    {
        $user = $this->createUser(['password' => Hash::make('current_password')]);
        $data = [
            'current_password' => 'current_password',
            'password'         => 'new_password',
        ];

        $this->actingAs($user)
            ->get(route('account.password'));

        $response = $this->actingAs($user)
            ->post(route('account.password'), $data);

        $response->assertSessionHasErrors([
            'password',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountPasswordController::store
     */
    public function update_password_wrong_current_password()
    {
        $user = $this->createUser(['password' => Hash::make('current_password')]);
        $data = [
            'current_password'      => 'wrong_current_password',
            'password'              => 'new_password',
            'password_confirmation' => 'new_password',
        ];

        $this->actingAs($user)
            ->get(route('account.password'));

        $response = $this->actingAs($user)
            ->post(route('account.password'), $data);

        $response->assertSessionHasErrors([
            'current_password',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountNotificationController::store
     */
    public function update_notifications()
    {
        $user = $this->createUser();
        factory(UserNotificationSetting::class)->create([
            'user_id' => $user->id,
        ]);

        $data = [
            'receive_email_notification' => 0,
            'receive_other_emails'       => 0,
            'receive_sms'                => 0,
        ];

        $this->actingAs($user)
            ->get(route('account.notifications'));

        $response = $this->actingAs($user)
            ->post(route('account.notifications'), $data);

        $response->assertRedirect(route('account.notifications'));

        $user->refresh();

        $this->assertArrayHas(
            [
                'receive_email_notification' => false,
                'receive_other_emails'       => false,
                'receive_sms'                => false,
            ],
            $user->notificationSettings->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountCloseController::destroy
     */
    public function close_account()
    {
        $user = $this->createUser();

        $this->assertTrue((bool) $user->status);

        $this->actingAs($user)
            ->get(route('account.close'));

        $this->actingAs($user)
            ->put(route('account.close'));

        $user->refresh();

        $this->assertFalse((bool) $user->status);
    }
}
