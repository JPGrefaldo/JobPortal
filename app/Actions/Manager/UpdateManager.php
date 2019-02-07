<?php

namespace App\Actions\Manager;

class UpdateManager
{
    /**
     * @param Manager $manager
     * @param string  $newManagerId
     */
    public function execute($manager, $currentManager)
    {
        return $manager->update([
            'manager_id' => $currentManager,
        ]);
    }
}