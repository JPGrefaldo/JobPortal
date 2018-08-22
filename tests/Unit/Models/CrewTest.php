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
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh, WithFaker;

    protected $crew;

    public function setUp()
    {
        parent::setUp();

        $this->crew = factory(Crew::class)->create();
    }

    /**
     * @test
     */
    public function user()
    {
        // given
        $user = factory(User::class)->create();

        // when
        $crew = factory(Crew::class)->create(['user_id' => $user->id]);

        // then
        $this->assertEquals($user->id, $crew->user->id);
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
        $this->assertEquals($position->id, $this->crew->positions->first()->id);
        $this->assertDatabaseHas('crew_positions', [
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
     * @expectedException App\Exceptions\ElectoralFraud
     */
    public function can_not_endorse_oneself()
    {
        $user       = factory(User::class)->create();
        $projectJob = factory(ProjectJob::class)->create();

        $user->endorse($user, $projectJob);

        $this->assertDatabaseMissing('endorsements', [
            'project_job_id' => $projectJob->id,
            'endorser_id'    => $user->id,
            'endorsee_id'    => $user->id,
        ]);
    }

    /**
     * @test
     */
    public function hasPosition()
    {
        // $this->withOutExceptionHandling();
        // given
        $user = factory(User::class)->create();
        $crew = factory(Crew::class)
            ->create(['user_id' => $user->id]);
        $appliedPosition = factory(Position::class)->create();
        $randomPosition  = factory(Position::class)->create();

        // when
        $crewPosition = factory(CrewPosition::class)
            ->create([
                'crew_id' => $user->crew->id,
                'position_id' => $appliedPosition->id
            ]);

        // then
        $this->assertTrue($user->hasPosition($appliedPosition));
        $this->assertFalse($user->hasPosition($randomPosition));
    }
}
