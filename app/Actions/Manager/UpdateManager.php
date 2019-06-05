<?php

namespace App\Actions\Manager;

use App\Models\Manager;

class UpdateManager
{
    /**
     * @param Manager $currentManager
     * @param int $newManagerID
     */
    public function execute(Manager $currentManager, $newManagerID): void
    {
        $currentManager->update([
            'manager_id' => $newManagerID,
        ]);
    }
}
