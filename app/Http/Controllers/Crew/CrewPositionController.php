<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\StoreCrewPosition;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCrewPositionRequest;
use App\Models\CrewPosition;
use App\Models\Position;

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

        $request->request->add([
            'method' => 'post',
        ]);

        $data = $request->validated();

        app(StoreCrewPosition::class)->execute($crew, $position, $data);

        return response()->json([
            'message' => 'success',
        ]);
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
     * @param \App\Models\CrewPosition $position
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function removeResume(CrewPosition $position)
    {
        return response()->json([
            'message' => $position->resume->delete() ? 'success' : 'failed',
        ]);
    }

    /**
     * @param \App\Models\CrewPosition $position
     * @return string
     */
    public function removeReel(CrewPosition $position)
    {
        return $position->reel()->delete() ? 'success' : 'failed';
    }
}
