<?php

namespace App\Actions\Manager;

use App\Models\Manager;

class CreateManager
{
    /**
     * @param string $manager_id
     * @param string $subordinate_id
     */
    public function execute($manager, $subordinate)
    {
        return Manager::create([
            'manager_id' => $manager,
            'subordinate_id' => $subordinate
        ]);
    }
}