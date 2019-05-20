<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\StoreCrewPosition;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCrewPositionRequest;
use App\Models\CrewPosition;
use App\Models\Position;
use App\Actions\Crew\DeleteCrewPositionResume;
use App\Actions\Crew\DeleteCrewPositionReel;
use App\Actions\Crew\DeleteCrewPositionGear;

class CrewPositionController extends Controller
{
    /**
     * @param \App\Models\Position $position
     * @param \App\Http\Requests\StoreCrewPositionRequest $request
     * @return \Illuminate\Http\JsonResponse
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
     * @param \App\Models\Position $position
     * @param \App\Http\Requests\StoreCrewPositionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Position $position, StoreCrewPositionRequest $request)
    {
        $crew = auth()->user()->crew;

        $data = $request->validated();

        app(StoreCrewPosition::class)->execute($crew, $position, $data);

        return response()->json([
            'message' => 'success',
        ]);
    }

    /**
     * @param \App\Models\Position $position
     * @return string
     */
    public function destroy(Position $position)
    {
        $crew = auth()->user()->crew;

        app(DeleteCrewPositionResume::class)->execute($crew, $position);
        app(DeleteCrewPositionReel::class)->execute($crew, $position);
        app(DeleteCrewPositionGear::class)->execute($crew, $position);

        return $crew->crewPositions()->where('position_id', $position->id)->delete() ? 'success' : 'failed';
    }

    /**
     * @param \App\Models\Position $position
     * @return \App\Models\CrewPosition|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getPositionData(Position $position)
    {
        $crew = auth()->user()->crew;

        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)
            ->with([
                'resume',
                'gear',
                'reel',
            ])->firstOrFail();

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

    /**
     * @param \App\Models\CrewPosition $crewPosition
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function removeResume(Position $position)
    {
        $crew = auth()->user()->crew;

        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        if ($crewPosition->resume == null)
            return;

        return response()->json([
            'message' => $crewPosition->resume->delete() ? 'success' : 'failed',
        ]);
    }

    /**
     * @param \App\Models\CrewPosition $crewPosition
     * @return string
     */
    public function removeReel(Position $position)
    {
        $crew = auth()->user()->crew;

        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        if ($crewPosition->reel == null)
            return;

        return response()->json([
            'message' => $crewPosition->reel()->delete() ? 'success' : 'failed',
        ]);
    }

    /**
     * @param \App\Models\CrewPosition $crewPosition
     * @return string
     */
    public function removeGear(Position $position)
    {
        $crew = auth()->user()->crew;

        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        if ($crewPosition == null)
            return;

        return response()->json([
            'message' => $crewPosition->gear()->delete() ? 'success' : 'failed',
        ]);
    }
}
