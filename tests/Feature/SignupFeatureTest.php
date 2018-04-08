<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SignupFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /** @test */
    public function crew()
    {
        $fakerUser = factory(User::class)->make();
        $data = [
            'first_name'            => $fakerUser->first_name,
            'last_name'             => $fakerUser->last_name,
            'email'                 => $fakerUser->email,
            'email_confirmation'    => $fakerUser->email,
            'password'              => 'some_password',
            'password_confirmation' => 'some_password',
            'phone'                 => $fakerUser->phone,
            'receive_text'          => 1,
            'terms'                 => 1,
            '_token'                => csrf_token()
        ];

        Hash::shouldReceive('make')->once()->andReturn('hashed_password');

        $response = $this->post('signup/crew', $data);

        $response->assertRedirect('login');

        $this->assertDatabaseHas('users', [
            'first_name'        => $fakerUser->first_name,
            'last_name'         => $fakerUser->last_name,
            'email'             => $fakerUser->email,
            'phone'             => $fakerUser->phone,
            'password'          => 'hashed_password',
            'status'            => 1,
            'confirmed'         => 0,
        ]);

        // assert that the user has settings depending on the receive_text
        $user = User::where('email', $fakerUser->email)->first();

        $this->assertArraySubset(
            [
                'receive_email_notification' => 1,
                'receive_other_emails'       => 1,
                'receive_sms'                => 1,
            ],
            $user->notificationSettings->toArray()
        );

        // assert that the user has a crew role
        $this->assertTrue($user->hasRole(Role::CREW));

        // assert that the user is in the current site
        $site = $this->getCurrentSite();

        $this->assertTrue($user->hasSite($site->hostname));
    }

    /**
     * @param string $stringUuid
     */
    /*private function mockUUID($stringUuid)
    {
        $uuid = Uuid::fromString($stringUuid);
        $factoryMock = \Mockery::mock(UuidFactory::class . '[uuid4]', [
            'uuid4' => $uuid
        ]);

        Uuid::setFactory($factoryMock);
    }*/
}
