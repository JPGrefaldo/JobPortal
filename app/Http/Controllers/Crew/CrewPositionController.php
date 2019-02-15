<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\StoreCrewPosition;
use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class CrewPositionController extends Controller
{
    public function applyFor(Position $position, Request $request)
    {
        $crew = auth()->user()->crew;
        app(StoreCrewPosition::class)->execute($crew, $position, $request);
    }
}
