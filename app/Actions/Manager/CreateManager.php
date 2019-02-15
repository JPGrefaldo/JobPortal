<?php

namespace App\Actions\Manager;

use App\Models\Manager;

class CreateManager
{
    /**
     * @param string $managerId
     * @param string $subordinateId
     * @return \App\Models\Manager
     */
    public function execute($manager, $subordinate)
    {
        return Manager::create([
            'manager_id' => $manager,
            'subordinate_id' => $subordinate
        ]);
    }
}
