<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\DeleteCrewPositionGear;
use App\Actions\Crew\DeleteCrewPositionGearPhoto;
use App\Http\Controllers\Controller;
use App\Models\CrewPosition;
use App\Models\Position;
use Exception;
use Illuminate\Http\JsonResponse;

class CrewPositionGearController extends Controller
{
    /**
     * @param CrewPosition
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Position $position)
    {
        $crew = auth()->user()->crew;

        $result = app(DeleteCrewPositionGear::class)->execute($crew, $position);

        return response()->json([
            'message' => $result ? 'success' : 'failed',
        ]);
    }

    /**
     * @param CrewPosition
     * @return JsonResponse
     * @throws Exception
     */
    public function removePhoto(Position $position)
    {
        $crew = auth()->user()->crew;

        $result = app(DeleteCrewPositionGearPhoto::class)->execute($crew, $position);

        return response()->json([
            'message' => $result ? 'success' : 'failed',
        ]);
    }
}
