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

class EndorsementEndorsedFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers  \App\Http\Controllers\Crew\Endorsements\EndorsementEndorsedController::index
     */
    public function index()
    {
        list($user, $position, $request) = $this->createEndorsement(Carbon::now());

        $this->actingAs($user);

        $response = $this->getJson(route('crew.endorsement.endorsed', ['position' => $position->id]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'endorsement_request_id' => $request->id,
            ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\Endorsements\EndorsementEndorsedController::index
     */
    public function index_no_approved()
    {
        list($user, $position) = $this->createEndorsement();

        $this->actingAs($user);

        $response = $this->json('GET', route('crew.endorsement.endorsed', ['position' => $position->id]));

        $response->assertStatus(200)
            ->assertExactJson([]);
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
            'crew_id'     => $crew->id,
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
