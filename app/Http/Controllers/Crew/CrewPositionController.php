<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\StoreCrewPosition;
use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Rules\Reel;

class CrewPositionController extends Controller
{
    public function applyFor(Position $position, Request $request)
    {
        $crew = auth()->user()->crew;

        $data = $request->validate([
            'bio'               => 'required|nullable|string',
            'resume'            => 'required|file|mimes:pdf,doc,docx',
            'reel_link'         => ['nullable', 'string', new Reel()],
            'reel_file'         => 'nullable|file|mimes:mp4,avi,wmv | max:20000',
            'gear'              => 'nullable',
            'union_description' => 'nullable'
        ]);

        app(StoreCrewPosition::class)->execute($crew, $position, $data);
    }
}
