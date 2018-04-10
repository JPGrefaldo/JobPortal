<?php

namespace Tests\Unit\Services;

use App\Services\UsersServices;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersServicesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var UsersServices
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(UsersServices::class);
    }

    /** @test */
    public function create()
    {
        $fakerUser = factory(User::class)->make();
        $userData = [
            'first_name' => $fakerUser->first_name,
            'last_name'  => $fakerUser->last_name,
            'email'      => $fakerUser->email,
            'password'   => 'some_password',
            'phone'      => $fakerUser->phone,
        ];
        $notificationSettingsData = [
            'receive_sms' => 1
        ];


        Hash::shouldReceive('make')->once()->andReturn('hashed_password');

        $this->service->create($userData, $notificationSettingsData);

        $this->assertDatabaseHas('users', [
            'first_name' => $fakerUser->first_name,
            'last_name'  => $fakerUser->last_name,
            'email'      => $fakerUser->email,
            'phone'      => $fakerUser->phone,
            'password'   => 'hashed_password',
            'status'     => 1,
            'confirmed'  => 0,
        ]);

        // assert that the user has user settings
        $user = User::where('email', $fakerUser->email)->first();

        $this->assertArraySubset(
            [
                'receive_email_notification' => 1,
                'receive_other_emails'       => 1,
                'receive_sms'                => 1,
            ],
            $user->notificationSettings->toArray()
        );
    }

    /** @test */
    public function create_no_receive_sms()
    {
        $fakerUser = factory(User::class)->make();
        $userData = [
            'first_name' => $fakerUser->first_name,
            'last_name'  => $fakerUser->last_name,
            'email'      => $fakerUser->email,
            'password'   => 'some_password',
            'phone'      => $fakerUser->phone,
        ];
        $notificationSettingsData = [
            'receive_sms' => 0
        ];

        $this->service->create($userData, $notificationSettingsData);

        $user = User::where('email', $fakerUser->email)->first();

        $this->assertArraySubset(
            [
                'receive_email_notification' => 1,
                'receive_other_emails'       => 1,
                'receive_sms'                => 0,
            ],
            $user->notificationSettings->toArray()
        );
    }
}