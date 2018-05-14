<?php

namespace Tests\Unit\Services;

use App\Services\UsersServices;
use App\Models\User;
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
        $data      = [
            'first_name' => $fakerUser->first_name,
            'last_name'  => $fakerUser->last_name,
            'email'      => $fakerUser->email,
            'password'   => 'some_password',
            'phone'      => $fakerUser->phone,
        ];

        Hash::shouldReceive('make')->once()->andReturn('hashed_password');

        $user = $this->service->create($data);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);

        $this->assertArraySubset([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'],
            'password'   => 'hashed_password',
            'status'     => 1,
            'confirmed'  => false,
        ], $user->refresh()->makeVisible('password')->toArray());

        // assert the the user has a UUID
        $this->assertEquals(36, strlen($user->uuid));
    }

    /** @test */
    public function create_formatted()
    {
        $data = [
            'first_name' => 'john james',
            'last_name'  => 'doe',
            'email'      => 'TEST@mail.com',
            'password'   => 'some_password',
            'phone'      => '1234567890',
        ];

        Hash::shouldReceive('make')->once()->andReturn('hashed_password');

        $user = $this->service->create($data);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);

        $this->assertArraySubset([
            'first_name' => 'John James',
            'last_name'  => 'Doe',
            'email'      => 'test@mail.com',
            'password'   => 'hashed_password',
            'phone'      => '(123) 456-7890',
            'password'   => 'hashed_password',
            'status'     => 1,
            'confirmed'  => false,
        ], $user->refresh()->makeVisible('password')->toArray());

        // assert the the user has a UUID
        $this->assertEquals(36, strlen($user->uuid));
    }

    /** @test */
    public function prepare_data()
    {
        Hash::shouldReceive('make')->andReturn('hashed_password');

        // formatted
        $this->assertArraySubset(
            [
                'first_name' => 'John James',
                'last_name'  => 'Doe',
                'email'      => 'test@mail.com',
                'password'   => 'hashed_password',
                'phone'      => '(123) 456-7890',
            ],
            $this->service->prepareData([
                'first_name' => 'john james',
                'last_name'  => 'doe',
                'email'      => 'TEST@mail.com',
                'password'   => 'some_password',
                'phone'      => '1234567890',
            ])
        );

        // same
        $this->assertArraySubset(
            [
                'first_name' => 'John James',
                'last_name'  => 'Doe',
                'email'      => 'test@mail.com',
                'password'   => 'hashed_password',
                'phone'      => '(123) 456-7890',
            ],
            $this->service->prepareData([
                'first_name' => 'John James',
                'last_name'  => 'Doe',
                'email'      => 'test@mail.com',
                'password'   => 'password',
                'phone'      => '(123) 456-7890',
            ])
        );
    }

    /** @test */
    public function update_name()
    {
        $user = $this->createUser();

        $this->service->updateName('John James', 'Doe', $user);

        $this->assertArraySubset([
            'first_name' => 'John James',
            'last_name'  => 'Doe',
        ], $user->refresh()->toArray());
    }

    /** @test */
    public function update_name_formatted()
    {
        $user = $this->createUser();

        $this->service->updateName('JoHn jAMES', "O'neal", $user);

        $this->assertArraySubset([
            'first_name' => 'John James',
            'last_name'  => "O'Neal",
        ], $user->refresh()->toArray());
    }

    /** @test */
    public function update_contact()
    {
        $user = $this->createUser();

        $this->service->updateContact('test@mail.com', '(123) 456-7890', $user);

        $this->assertArraySubset([
            'email' => 'test@mail.com',
            'phone' => '(123) 456-7890',
        ], $user->refresh()->toArray());
    }

    /** @test */
    public function update_contact_formatted()
    {
        $user = $this->createUser();

        $this->service->updateContact('TEST@mail.com', '123.456.7890', $user);

        $this->assertArraySubset([
            'email' => 'test@mail.com',
            'phone' => '(123) 456-7890',
        ], $user->refresh()->toArray());
    }

    /** @test */
    public function update_password()
    {
        $user = $this->createUser();

        Hash::shouldReceive('make')->andReturn('hashed_password');

        $this->service->updatePassword('new_password', $user);

        $this->assertEquals('hashed_password', $user->password);
    }
}
