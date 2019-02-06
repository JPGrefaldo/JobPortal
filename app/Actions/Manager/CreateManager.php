<?php

namespace App\Actions\Manager;

use App\Models\Manager;
use App\Models\Role;
use App\Models\Rules\UserRules;
use App\Models\User;
use App\Utils\FormatUtils;

class CreateManager
{
    /**
     * @param string $email
     * @param User $user
     */
    public function execute($email, $user)
    {
        $email = FormatUtils::email($email);

        if ($manager = User::where('email', $email)->first()){
            
            $oldData = Manager::where('subordinate_id', $user->id)->first();

            if($oldData->id)
            {
                return $oldData->update([
                    'manager_id' => $manager->id,
                ]);
            }

            return Manager::create([
                'manager_id' => $manager->id,
                'subordinate_id' => $user->id,
                'role_id' => Role::getRoleIdByName(Role::MANAGER),
            ]);
        }
    }
}