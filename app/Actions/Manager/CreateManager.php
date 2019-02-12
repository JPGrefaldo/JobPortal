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
    public function execute($managerId, $subordinateId)
    {
        return Manager::create([
            'manager_id' => $managerId,
            'subordinate_id' => $subordinateId
        ]);
    }
}