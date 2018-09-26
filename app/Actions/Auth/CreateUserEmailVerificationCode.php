<?php

namespace App\Actions\Auth;


use App\Models\Role;
use App\Models\User;
use App\Utils\StrUtils;

class CreateUserEmailVerificationCode
{
    /**
     * @param User $user
     * @param $roleName
     */
    public function execute($user)
    {
        $user->emailVerificationCode()->create([
            'code' => StrUtils::createRandomString(),
        ]);
    }
}