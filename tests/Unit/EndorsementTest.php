<?php

namespace Tests\Unit;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\EndorsementRequest;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EndorsementTest extends TestCase
{
    use RefreshDatabase;

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

    /**
     * @test
     */
    public function endorser()
    {
        // given
        $crew = factory(Crew::class)->create();
        $endorser = factory(Crew::class)->create();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $crew->id
        ]);
        $endorsementRequest = factory(EndorsementRequest::class)->create([
            'crew_position_id' => $crewPosition->id
        ]);

        // when
        $endorsement = factory(Endorsement::class)->create([
            'endorsement_request_id' => $endorsementRequest->id,
            // 'endorser_email' => $endorser->user->email,
            'endorser_id' => $endorser->id,
        ]);

        // then
        $this->assertEquals(
            $endorser->bio,
            $endorsement->endorser->bio
        );
    }
}
