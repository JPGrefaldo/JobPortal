<?php

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\CreateUserEmailVerificationCode;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CreateUserEmailVerificationCodeTest extends TestCase
{
    use DatabaseMigrations, SeedDatabaseAfterRefresh;

    /**
     * @var CreateUserEmailVerificationCode
     */
    public $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(CreateUserEmailVerificationCode::class);
    }

    /**
     * @test
     * @covers \App\Actions\Auth\CreateUserEmailVerificationCode::execute
     */
    public function execute()
    {
        $user = factory(User::class)->create();

        $this->assertDatabaseMissing('email_verification_codes', [
            'user_id' => 1,
        ]);

        $this->service->execute($user);

        $this->assertDatabaseHas('email_verification_codes', [
            'user_id' => 1,
        ]);
    }
}
