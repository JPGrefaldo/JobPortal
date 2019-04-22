<?php

namespace App\Actions\Auth;

use App\Models\EmailVerificationCode;
use App\Models\User;
use App\Utils\StrUtils;

class CreateUserEmailVerificationCode
{
    /**
     * @param User $user
     * @return \App\Models\EmailVerificationCode
     */
    public function execute(User $user): EmailVerificationCode
    {
        return EmailVerificationCode::firstOrCreate([
            'user_id' => $user->id,
        ], [
            'code' => StrUtils::createRandomString(),
        ]);
    }
}
