<?php

namespace Tests\Unit;

use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\EndorsementEndorser;
use App\Models\EndorsementRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class EndorsementTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers
     */
    public function endorser()
    {
        $position = $this->getRandomPosition();
        $crew = $this->createCrew()->crew;
        $endorser = $this->createCrew()->crew;

        $endorserCrewPosition = factory(CrewPosition::class)->create([
            'crew_id'     => $endorser->id,
            'position_id' => $position,
        ]);
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id'     => $crew->id,
            'position_id' => $position,
        ]);

        $request = factory(EndorsementRequest::class)->create([
            'endorsement_endorser_id' => EndorsementEndorser::create([
                'user_id' => $endorser->user_id,
            ]),
        ]);

        $endorsement = factory(Endorsement::class)->create([
            'endorsement_request_id' => $request->id,
            'crew_position_id'       => $crewPosition->id,
        ]);

        $this->assertEquals($endorser->id, $endorsement->endorser->first()->user->id);
    }
}
