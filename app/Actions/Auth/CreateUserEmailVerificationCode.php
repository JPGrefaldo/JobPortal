<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Utils\StrUtils;

class CreateUserEmailVerificationCode
{
    /**
     * @param User $user
     * @param $roleName
     */
    public function execute(User $user): void
    {
        $user->emailVerificationCode()->create([
            'code' => StrUtils::createRandomString(),
        ]);
    }
}
