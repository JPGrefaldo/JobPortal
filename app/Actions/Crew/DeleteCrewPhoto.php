<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Illuminate\Support\Facades\Storage;

class DeleteCrewPhoto
{
    /**
     * @param \App\Models\Crew $crew
     * @param array $data
     */
    public function execute(Crew $crew)
    {
        Storage::disk('s3')->delete($crew->photo_path);
        
        $crew->update([
        	'photo_path' => ''
        ]);
    }
}
