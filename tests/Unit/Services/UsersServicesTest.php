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

        $this->service->create($data);

        $user = User::whereEmail($fakerUser->email)->first();

        $this->assertArraySubset([
            'first_name' => $fakerUser->first_name,
            'last_name'  => $fakerUser->last_name,
            'email'      => $fakerUser->email,
            'phone'      => $fakerUser->phone,
            'password'   => 'hashed_password',
            'status'     => 1,
            'confirmed'  => false,
        ], $user->makeVisible('password')->toArray());

        // assert the the user has a UUID
        $this->assertEquals(36, strlen($user->uuid));
    }

    /** @test */
    public function update_name()
    {
        $user = $this->createUser();

        $user = $this->service->updateName('John James', 'Doe', $user);

        $this->assertArraySubset([
            'first_name' => 'John James',
            'last_name'  => 'Doe',
        ], $user->refresh()->toArray());
    }

    /** @test */
    public function update_name_formatted()
    {
        $user = $this->createUser();

        $user = $this->service->updateName('JoHn jAMES', "O'neal", $user);

        $this->assertArraySubset([
            'first_name' => 'John James',
            'last_name'  => "O'Neal",
        ], $user->refresh()->toArray());
    }
}
