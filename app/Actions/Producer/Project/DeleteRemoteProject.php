<?php

namespace App\Actions\Producer\Project;

class DeleteRemoteProject
{
    public function execute(int $projectJob): void
    {
        app(StubProjectJob::class)->delete($projectJob);
    }
}