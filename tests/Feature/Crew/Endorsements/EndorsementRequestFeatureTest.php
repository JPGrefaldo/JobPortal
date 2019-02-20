<?php

namespace Tests\Feature;

use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\EndorsementEndorser;
use App\Models\EndorsementRequest;
use App\Models\Position;
use App\Utils\StrUtils;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class EndorsementRequestFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\Endorsements\EndorsementRequestController::destroy
     */
    public function destroy()
    {
        $this->disableExceptionHandling();
        list($user, $postition, $request) = $this->createEndorsement(Carbon::now());

        $this->actingAs($user);

        $response = $this->delete(route('crew.endorsement.request.destroy', ['request' => $request->id]));

        $response->assertSuccessful();

        $request->refresh();
        $this->assertNotNull($request->deleted_at);
    }

    /**
     * @return array
     */
    private function createEndorsement($approved_at = null): array
    {
        $endorser = factory(EndorsementEndorser::class)->create();

        $user = $this->createCrew();
        $crew = $user->crew;
        $position = Position::inRandomOrder()->get()->first();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $crew->id,
            'position_id' => $position,
        ]);
        $request = EndorsementRequest::create([
            'endorsement_endorser_id' => $endorser->id,
            'token'                   => StrUtils::createRandomString(),
            'message'                 => 'test',
        ]);
        $endorsement = Endorsement::create([
            'endorsement_request_id' => $request->id,
            'crew_position_id'       => $crewPosition->id,
            'approved_at'            => $approved_at,
        ]);
        return [
            $user,
            $position,
            $request,
        ];
    }
}
