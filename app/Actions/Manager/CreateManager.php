<?php

namespace App\Actions\Manager;

use App\Models\Manager;

class CreateManager
{
    /**
     * @param string $manager_id
     * @param string $subordinate_id
     */
    public function execute($managerId, $subordinateId)
    {
        return Manager::create([
            'manager_id' => $managerId,
            'subordinate_id' => $subordinateId
        ]);
    }
}
