<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\DeleteCrewPhoto;
use App\Http\Controllers\Controller;
use App\Models\Crew;

class CrewPhotoController extends Controller
{
    /**
     * deletes the profile photo of the crew
     *
     * @param  \App\Models\Crew $crew
     * @return \Illuminate\Http\Response
     */
    public function destroy(Crew $crew)
    {
        app(DeleteCrewPhoto::class)->execute($crew);
        return response('success');
    }
}
