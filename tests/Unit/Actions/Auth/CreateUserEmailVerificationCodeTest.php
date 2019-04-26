<?php

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\CreateUserEmailVerificationCode;
use App\Utils\StrUtils;
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

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(CreateUserEmailVerificationCode::class);
    }

    /**
     * @test
     * @covers \App\Actions\Auth\CreateUserEmailVerificationCode::execute
     */
    public function create_new_email_verification_code()
    {
        $user = $this->createUser();

        $this->assertDatabaseMissing('email_verification_codes', [
            'user_id' => $user->id,
        ]);

        $this->service->execute($user);

        $this->assertDatabaseHas('email_verification_codes', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Auth\CreateUserEmailVerificationCode::execute
     */
    public function try_to_create_a_new_email_verification_code_when_one_exists()
    {
        $user = $this->createUser();

        $code = StrUtils::createRandomString();

        $emailCode = $user->emailVerificationCode()->create([
            'code' => $code,
        ]);

        $this->assertDatabaseHas('email_verification_codes', [
            'user_id' => $user->id,
        ]);

        $this->service->execute($user);

        $this->assertCount(1, $user->emailVerificationCode()->get());
        $this->assertEquals($code, $emailCode->code);
    }
}
