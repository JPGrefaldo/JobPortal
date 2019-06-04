<?php

namespace App\Actions\Crew;

use App\Models\Crew;

class EditCrew
{
    /**
     * @param Crew $crew
     * @param array $data
     */
    public function execute(Crew $crew, array $data): void
    {
        if (! isset($data['bio']) || empty($data['bio'])) {
            return;
        }

        $crew->refresh()->update([
            'bio' => $data['bio'],
        ]);
    }
}
