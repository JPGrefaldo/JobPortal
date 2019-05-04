<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\StoreCrewPosition;
use App\Actions\Crew\GetCrewPositionByPosition;
use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Rules\Reel;
use App\Http\Requests\StoreCrewPositionRequest;

class CrewPositionController extends Controller
{
    public function applyFor(Position $position, StoreCrewPositionRequest $request)
    {
        $crew = auth()->user()->crew;

        $data = $request->validate([
            'bio'               => 'required|nullable|string',
            'resume'            => 'required|file|mimes:pdf,doc,docx',
            'reel_link'         => ['nullable','required_without:reel_file', 'string', new Reel()],
            'reel_file'         => 'nullable|required_without:reel_link|file|mimes:mp4,avi,wmv | max:20000',
            'gear'              => 'nullable',
            'union_description' => 'nullable'
        ]);

        app(StoreCrewPosition::class)->execute($crew, $position, $data);
    }

    public function fetchPosition(Position $position)
    {
        return app(GetCrewPositionByPosition::class)->execute(auth()->user(), $position)->load(['reel','gear','resume']);
    }
}
