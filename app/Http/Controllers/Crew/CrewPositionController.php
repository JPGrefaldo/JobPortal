<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\DeleteCrewPosition;
use App\Actions\Crew\DeleteCrewPositionGear;
use App\Actions\Crew\DeleteCrewPositionReel;
use App\Actions\Crew\DeleteCrewPositionResume;
use App\Actions\Crew\StoreCrewPosition;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCrewPositionRequest;
use App\Models\CrewPosition;
use App\Models\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class CrewPositionController extends Controller
{
    /**
     * @param Position $position
     * @param StoreCrewPositionRequest $request
     * @return JsonResponse
     */
    public function store(Position $position, StoreCrewPositionRequest $request)
    {
        $crew = auth()->user()->crew;

        $data = $request->validated();

        app(StoreCrewPosition::class)->execute($crew, $position, $data);

        return response()->json([
            'message' => 'success',
        ]);
    }

    /**
     * @param Position $position
     * @param StoreCrewPositionRequest $request
     * @return JsonResponse
     */
    public function update(Position $position, StoreCrewPositionRequest $request)
    {
        $crew = auth()->user()->crew;

        $data = $request->validated();

        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        $data['crew_position_id'] = $crewPosition->id;

        app(StoreCrewPosition::class)->execute($crew, $position, $data);

        return response()->json([
            'message' => 'success',
        ]);
    }

    /**
     * @param Position $position
     * @return string
     */
    public function destroy(Position $position)
    {
        $crew = auth()->user()->crew;

        app(DeleteCrewPositionResume::class)->execute($crew, $position);
        app(DeleteCrewPositionReel::class)->execute($crew, $position);
        app(DeleteCrewPositionGear::class)->execute($crew, $position);

        return app(DeleteCrewPosition::class)->execute($crew, $position);
    }

    /**
     * @param Position $position
     * @return CrewPosition|Builder|Model
     */
    public function show(Position $position)
    {
        $crew = auth()->user()->crew;

        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)
            ->with([
                'resume',
                'gear',
                'reel',
            ])
            ->firstOrFail();

        return $crewPosition;
    }

    /**
     * @return array
     */
    public function getPositionList()
    {
        $crew = auth()->user()->crew;

        return $crew->crewPositions->pluck('position_id');
    }
}
