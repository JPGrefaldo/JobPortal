<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Illuminate\Support\Facades\Storage;

class DeleteCrewProfilePhoto
{
    /**
     * @param \App\Models\Crew $crew
     * @param array $data
     */
    public function execute(Crew $crew)
    {
        $crew->update([
        	'photo_path' => ''
        ]);
    }
}
