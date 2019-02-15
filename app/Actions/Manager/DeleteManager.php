<?php

namespace App\Actions\Manager;

use App\Models\Manager;

class DeleteManager
{
    public function execute($manager, $subordinate)
    {
        Manager::where([
                ['manager_id', '=', $manager->id],
                ['subordinate_id', '=', $subordinate->id]
            ])->delete();
    }
}