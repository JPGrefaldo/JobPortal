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
     */
    public function user()
    {
        // given
        $user = $this->createUser();

        // when
        $emailVerificationCode = factory(EmailVerificationCode::class)->create([
            'user_id' => $user->id
        ]);

        // then
        $this->assertEquals($user->email, $emailVerificationCode->user->email);
    }
}
