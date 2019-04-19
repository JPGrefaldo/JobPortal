<?php

namespace App\Actions\Producer\Project;

class DeleteRemoteProject
{
    /**
     * @param int $projectJob
     */
    public function execute(int $projectJob): void
    {
        app(StubProjectJob::class)->delete($projectJob);
    }
}
