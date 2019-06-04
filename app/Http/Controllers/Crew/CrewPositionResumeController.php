<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\DeleteCrewPositionResume;
use App\Http\Controllers\Controller;
use App\Models\CrewPosition;
use App\Models\Position;
use Exception;
use Illuminate\Http\JsonResponse;

class CrewPositionResumeController extends Controller
{
    /**
     * @param CrewPosition
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Position $position)
    {
        $crew = auth()->user()->crew;

        $result = app(DeleteCrewPositionResume::class)->execute($crew, $position);

        return response()->json([
            'message' => $result ? 'success' : 'failed',
        ]);
    }
}
