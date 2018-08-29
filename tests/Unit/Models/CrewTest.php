<?php

namespace Tests\Unit\Models;

use App\Models\Crew;
use App\Models\CrewGear;
use App\Models\CrewPosition;
use App\Models\CrewReel;
use App\Models\CrewResume;
use App\Models\CrewSocial;
use App\Models\EndorsementRequest;
use App\Models\Position;
use App\Models\ProjectJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CrewTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $crew;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->crew = factory(Crew::class)->create(['user_id' => $this->user->id]);
    }

    /**
     * @test
     */
    public function user()
    {
        $this->assertEquals($this->user->id, $this->crew->user->id);
    }

    /**
     * @test
     */
    public function positions()
    {
        // given
        factory(Position::class, 3)->create()->each(function ($position) {
            // when
            $crewPosition = factory(CrewPosition::class)->make()->toArray();
            $this->crew->positions()->attach(
                $position,
                array_only($crewPosition, ['details', 'union_description'])
            );
        });

        // then
        $this->assertCount(3, $this->crew->positions);
    }

    /**
     * @test
     */
    public function reels()
    {
        // when
        $this->crew->reels()->saveMany(factory(CrewReel::class, 3)->create());

        // then
        $this->assertCount(3, $this->crew->reels);
    }

    /**
     * @test
     */
    public function resumes()
    {
        // when
        $this->crew->resumes()->saveMany(factory(CrewResume::class, 3)->create());

        // then
        $this->assertCount(3, $this->crew->resumes);
    }

    /**
     * @test
     */
    public function gears()
    {
        // when
        $this->crew->gears()->saveMany(factory(CrewGear::class, 3)->create());

        // then
        $this->assertCount(3, $this->crew->gears);
    }

    /**
     * @test
     */
    public function social()
    {
        // when
        $this->crew->social()->saveMany(factory(CrewSocial::class, 3)->create());

        // then
        $this->assertCount(3, $this->crew->social);
    }

    /**
     * @test
     */
    public function endorsementRequests()
    {
        // given
        $position = factory(Position::class)->create();
        $randomPosition = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $this->crew->id,
            'position_id' => $position->id
        ]);

        // when
        $endorsementRequest = EndorsementRequest::create([
            'crew_position_id' => $position->id,
            'token' => EndorsementRequest::generateToken(),
        ]);

        // then
        $this->assertEquals(
            $endorsementRequest->token,
            $this->crew->endorsementRequests()->first()->token
        );
        $this->assertInstanceOf(
            EndorsementRequest::class,
            $this->crew->endorsementRequests()->first()
        );
    }

    /**
     * @test
     */
    public function applyFor()
    {
        // given
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->make()->toArray();

        // when
        $this->crew->applyFor(
            $position,
            array_only($crewPosition, ['details', 'union_description'])
        );

        // then
        $this->assertEquals(
            $position->name,
            $this->crew->positions->first()->name
        );
        $this->assertDatabaseHas('crew_position', [
            'crew_id' => $this->crew->id,
            'position_id' => $position->id,
            'details' => $crewPosition['details'],
            'union_description' => $crewPosition['union_description'],
        ]);
    }

    /**
     * @test
     */
    public function approve()
    {
        // given
        $position = factory(Position::class)->create();
        $anotherCrew = factory(Crew::class)->create();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $anotherCrew->id,
            'position_id' => $position->id
        ]);
        $endorsementRequest = factory(EndorsementRequest::class)->create([
            'crew_position_id' => $crewPosition->id
        ]);
        $comment = $this->faker->sentence;

        // when
        $this->crew->approve($endorsementRequest, ['comment' => $comment]);

        // then
        $this->assertDatabaseHas('endorsements', [
            'endorsement_request_id' => $endorsementRequest->id,
            'endorser_id' => $this->crew->user->id,
            'endorser_email' => $this->crew->user->email,
            'comment' => $comment,
        ]);
    }

    /**
     * @test
     */
    // public function endorse()
    // {
    //     // given
    //     $endorsee = factory(Crew::class)->create();
    //     $endorser = factory(Crew::class)->create();
    //     $position = factory(Position::class)->create();
    //     $crewPosition = factory(CrewPosition::class)->create([
    //         'crew_id' => $endorsee->id,
    //         'position_id' => $position->id
    //     ]);
    //     $endorsee->applyFor($position, $crewPosition);
    //     $endorsementRequest = $endorsee->createEndorsementRequest();

    //     // when
    //     $endorser->endorse($endorsee);
    //     // endorse endorsee to a position
    //     // make sure that the endorsee has applied to the position
    //     // make sure that the endorser is not endorsing himself


    //     // then
    //     $this->assertDatabaseHas('endorsements', [
    //         'endorsement_request_id' => $endorsementRequest,
    //         'endorser_id' => $endorser->user->crew->id,
    //         'endorser_email' => $endorser->user->email,
    //     ]);
    // }

    /**
     * @test
     */
    public function can_not_endorse_oneself()
    {
        $projectJob = factory(ProjectJob::class)->create();

        $bool = $this->crew->endorse($this->crew, $projectJob);

        $this->assertFalse($bool);
        $this->assertDatabaseMissing('endorsements', [
            'project_job_id' => $projectJob->id,
            'endorser_id'    => $this->user->id,
            'endorsee_id'    => $this->user->id,
        ]);
    }

    /**
     * @test
     */
    public function hasPosition()
    {
        // given
        $appliedPosition = factory(Position::class)->create();
        $randomPosition  = factory(Position::class)->create();

        // when
        $crewPosition = factory(CrewPosition::class)
            ->create([
                'crew_id' => $this->crew->id,
                'position_id' => $appliedPosition->id
            ]);

        // then
        $this->assertTrue($this->crew->hasPosition($appliedPosition));
        $this->assertFalse($this->crew->hasPosition($randomPosition));
    }
}
