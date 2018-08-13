<?php

namespace Tests\Unit;

use App\EndorsementRequest;
use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class EndorsementRequestTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     */
    public function crewPosition()
    {
        // given
        $crewPosition = factory(CrewPosition::class)->create();

        // when
        $endorsementRequest = factory(EndorsementRequest::class)->create(['crew_position_id' => $crewPosition->id]);

        // then
        $this->assertEquals($crewPosition->id, $endorsementRequest->crewPosition->id);
    }

    /**
     * @test
     */
    public function endorsements()
    {
        // given
        $endorsementRequest = factory(EndorsementRequest::class)->create();

        // when
        factory(Endorsement::class, 2)->states('approved')->create(['endorsement_request_id' => $endorsementRequest->id]);

        // then
        $this->assertCount(2, $endorsementRequest->endorsements);
    }

    /**
     * @test
     */
    public function isApprovedBy()
    {
        // $this->withoutExceptionHandling();
        // given
        $user = factory(User::class)->create();
        $randomUser = factory(User::class)->create();
        $endorsementRequest = factory(EndorsementRequest::class)->create();

        // when
        $endorsement = factory(Endorsement::class)
            ->states('approved')
            ->create(['endorsement_request_id' => $endorsementRequest->id, 'endorser_email' => $user->email]);

        // then
        $this->assertTrue($endorsementRequest->isApprovedBy($user));
        $this->assertFalse($endorsementRequest->isApprovedBy($randomUser));
    }

    /**
     * @test
     */
    public function isRequestedBy()
    {
        // given
        $user = factory(User::class)->create();
        $crew = factory(Crew::class)->create(['user_id' => $user->id]);
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create(['crew_id' => $crew->id, 'position_id' => $position->id]);
        $endorsementRequest = factory(EndorsementRequest::class)->create(['crew_position_id' => $crewPosition->id]);
        $randomUser = factory(User::class)->create();

        // then
        $this->assertTrue($endorsementRequest->isRequestedBy($user));
        $this->assertFalse($endorsementRequest->isRequestedBy($randomUser));
    }

    /**
     * @test
     */
    public function endorsee()
    {
        // given
        $endorsee = factory(Crew::class)->states('withRole')->create();
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create(['crew_id' => $endorsee->id, 'position_id' => $position->id]);
        // crew

        // when
        $endorsementRequest = factory(EndorsementRequest::class)->create(['crew_position_id' => $crewPosition->id]);

        // then
        $this->assertEquals($endorsee->toArray(), $endorsementRequest->endorsee->toArray());
    }

    /**
     * @test
     */
    public function position()
    {
        // given
        $crew = factory(Crew::class)->states('withRole')->create();
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create(['crew_id' => $crew->id, 'position_id' => $position->id]);

        // when
        $endorsementRequest = factory(EndorsementRequest::class)->create(['crew_position_id' => $crewPosition->id]);

        // then
        $this->assertEquals($position->id, $endorsementRequest->position->id);
    }
}
