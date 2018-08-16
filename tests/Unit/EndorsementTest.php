<?php

namespace Tests\Unit;

use App\EndorsementRequest;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class EndorsementTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     */
    public function position()
    {
        // given
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create(['position_id' => $position->id]);
        $endorsementRequest = factory(EndorsementRequest::class)->create(['crew_position_id' => $crewPosition->id]);

        // when
        $endorsement = factory(Endorsement::class)->create(['endorsement_request_id' => $endorsementRequest]);

        // then
        $this->assertEquals($position->id, $endorsement->position->id);
    }

    /**
     * @test
     */
    public function request()
    {
        // given
        $endorsementRequest = factory(EndorsementRequest::class)->create();

        // when
        $endorsement = factory(Endorsement::class)->create(['endorsement_request_id' => $endorsementRequest->id]);

        // then
        $this->assertEquals($endorsementRequest->id, $endorsement->request->id);
    }
}
