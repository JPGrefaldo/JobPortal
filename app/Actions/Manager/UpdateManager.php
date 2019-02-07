<?php

namespace App\Actions\Manager;

class UpdateManager
{
    /**
     * @param Manager $manager
     * @param string  $newManagerId
     */
    public function execute($manager, $newManagerId)
    {
        return $manager->update([
            'manager_id' => $newManagerId,
        ]);
    }
}