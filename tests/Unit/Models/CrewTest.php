<?php

namespace Tests\Unit\Models;

use App\Models\Crew;
use App\Models\CrewGear;
use App\Models\CrewPosition;
use App\Models\CrewReel;
use App\Models\CrewResume;
use App\Models\CrewSocial;
use App\Models\Endorsement;
use App\Models\EndorsementRequest;
use App\Models\Position;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrewTest extends TestCase
{
    use RefreshDatabase;

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
        $this->assertEquals($this->user->email, $this->crew->user->email);
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
    public function socials()
    {
        // when
        $this->crew->socials()->saveMany(factory(CrewSocial::class, 3)->create());

        // then
        $this->assertCount(3, $this->crew->socials);
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
        $endorsementRequest = factory(EndorsementRequest::class)->create();
        $comment = 'Some comment';

        // when
        $this->crew->approve($endorsementRequest, ['comment' => $comment]);
        $this->crew->approve($endorsementRequest, ['comment' => $comment]);

        // then
        $this->assertDatabaseHas('endorsements', [
            'endorsement_request_id' => $endorsementRequest->id,
            'endorser_id' => $this->crew->user->id,
            'comment' => $comment,
        ]);
        $this->assertCount(1, Endorsement::all());
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

    /**
     * @test
     * @covers \App\Models\Crew::endorsements
     */
    public function endorsements()
    {
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $this->crew->id,
        ]);
        $endorsementRequest = factory(EndorsementRequest::class)->create([
            'crew_position_id' => $crewPosition->id,
        ]);

        $endorsements = factory(Endorsement::class)->states('approved')->create([
            'endorser_id' => $this->crew->id,
        ]);

        $this->assertEquals(
            $this->crew->endorsements->pluck('approved_at'),
            $endorsements->pluck('approved_at')
        );
    }

    /**
     * @test
     * @covers \App\Models\Crew::endorsements
     */
    public function no_endorsements()
    {
        $this->assertEquals(
            0,
            $this->crew->endorsements->count()
        );
    }

    /**
     * @test
     * @covers \App\Models\Crew::approvedEndorsements
     */
    public function approved_endorsements()
    {
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $this->crew->id,
        ]);
        $endorsementRequest = factory(EndorsementRequest::class)->create([
            'crew_position_id' => $crewPosition->id,
        ]);

        $endorsements = factory(Endorsement::class)->states('approved')->create([
            'endorser_id' => $this->crew->id,
        ]);

        $this->assertEquals(
            $this->crew->approvedEndorsements->pluck('approved_at'),
            $endorsements->pluck('approved_at')
        );
    }

    /**
     * @test
     * @covers \App\Models\Crew::approvedEndorsements
     */
    public function no_approved_endorsements()
    {
        $this->assertEquals(0, $this->crew->approvedEndorsements->count());
    }

    /**
     * @test
     */
    public function projects()
    {
        // when
        $project = factory(Project::class, 3)->create()->each(function ($project) {
            $this->crew->projects()->attach($project);
        });

        // then
        $this->assertCount(3, $this->crew->projects);
    }
}
