<?php

namespace App\Actions\Manager;

use App\Models\Manager;
use App\Models\Rules\UserRules;
use App\Models\User;
use App\Utils\FormatUtils;

class CreateManager
{
    public function execute($email, $user)
    {
        $email = FormatUtils::email($email);

        $manager = User::where('email', $email)->first();

        return Manager::create([
            'manager_id' => $manager->id,
            'subordinate_id' => $user->id,
        ]);
    }
}