<?php

namespace App\Actions\User;

use App\Actions\Endorsement\ConvertEndorserFromEmailToUser;
use App\Models\User;

class PostCreateUser
{
    /**
     * @var array
     */
    public $actions = [
        ConvertEndorserFromEmailToUser::class,
    ];

    /**
     * @param \App\Models\User $user
     */
    public function execute(User $user): void
    {
        foreach ($this->actions as $action) {
            app($action)->execute($user);
        }
    }
}