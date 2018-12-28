<?php

namespace Tests\Unit\Models;

use App\Models\EmailVerificationCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailVerificationCodeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @covers \App\Models\EmailVerificationCode::user
     */
    public function user()
    {
        $user = $this->createUser();

        $emailVerificationCode = factory(EmailVerificationCode::class)->create([
            'user_id' => $user->id
        ]);

        $this->assertEquals(
            $user->email,
            $emailVerificationCode->user->email
        );
    }
}
