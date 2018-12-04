<?php

namespace App\Actions\User;

use App\Actions\Endorsement\ConvertEndorserFromEmailToUser;
use App\Models\User;

class PostCreateUser
{
    public $actions = [
        ConvertEndorserFromEmailToUser::class,
    ];

    public function execute(User $user)
    {
        foreach ($this->actions as $action) {
            app($action)->execute($user);
        }
    }
}
