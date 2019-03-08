<?php

namespace App\Actions\Manager;

use App\Models\Manager;
use App\Models\User;

class DeleteManager
{
    /**
     * @param int $managerId
     * @param int $subordinateId
     * @throws \Exception
     */
    public function execute(int $managerId, int $subordinateId): void
    {
        Manager::where([
                ['manager_id', '=', $managerId],
                ['subordinate_id', '=', $subordinateId]
            ])->delete();
    }
}