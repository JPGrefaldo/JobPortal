<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Illuminate\Support\Facades\Storage;

class EditCrew
{
    /**
     * @param \App\Models\Crew $crew
     * @param array $data
     */
    public function execute(Crew $crew, array $data): void
    {
        app(EditCrewPhoto::class)->execute($crew, $data);

        $crew->refresh()->update([
            'bio'        => $data['bio'],
        ]);
    }
}
