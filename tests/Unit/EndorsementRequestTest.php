<?php

namespace Tests\Unit;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\EndorsementRequest;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EndorsementRequestTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $crew;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->states('withCrewRole')->create();
        $this->crew = factory(Crew::class)->create([
            'user_id' => $this->user->id
        ]);
    }

    /**
     * @test
     */
    public function endorsee()
    {
        // given
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $this->crew->id,
            'position_id' => $position->id
        ]);

        // when
        $endorsementRequest = factory(EndorsementRequest::class)->create([
            'crew_position_id' => $crewPosition->id
        ]);

        // then
        $this->assertEquals(
            $this->crew->toArray(),
            $endorsementRequest->endorsee->toArray()
        );
    }

    /**
     * @test
     */
    public function endorsements()
    {
        // given
        $endorsementRequest = factory(EndorsementRequest::class)->create();

        // when
        factory(Endorsement::class, 2)
            ->create([
                'endorsement_request_id' => $endorsementRequest->id
            ]);

        // then
        $this->assertCount(2, $endorsementRequest->endorsements);
    }

    /**
     * @test
     */
    public function endorsementBy()
    {
        // $this->withoutExceptionHandling();

        // given
        $endorsementRequest = factory(EndorsementRequest::class)->create();

        // when
        $endorsement = factory(Endorsement::class)
            ->states('approved')
            ->create([
                'endorsement_request_id' => $endorsementRequest->id,
                'endorser_id' => $this->crew->id,
            ]);

        // then
        $this->assertEquals(
            $this->crew->id,
            $endorsementRequest->endorsementBy($this->crew)->first()->endorser_id
        );
    }

    /**
     * @test
     */
    public function isApprovedBy()
    {
        // $this->withoutExceptionHandling();

        // given
        $randomCrew = factory(Crew::class)->create();
        $endorsementRequest = factory(EndorsementRequest::class)->create();

        // when
        $endorsement = factory(Endorsement::class)
            ->states('approved')
            ->create([
                'endorsement_request_id' => $endorsementRequest->id,
                'endorser_id' => $this->crew->id
            ]);

        // then
        $this->assertTrue($endorsementRequest->isApprovedBy($this->crew));
        $this->assertFalse($endorsementRequest->isApprovedBy($randomCrew));
    }

    /**
     * @test
     */
    public function isRequestedBy()
    {
        // given
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $this->crew->id
        ]);
        $endorsementRequest = factory(EndorsementRequest::class)->create([
            'crew_position_id' => $crewPosition->id
        ]);
        $randomCrew = factory(Crew::class)->create();

        // then
        $this->assertTrue($endorsementRequest->isRequestedBy($this->crew));
        $this->assertFalse($endorsementRequest->isRequestedBy($randomCrew));
    }
}
