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

        $this->user = $this->createUser();
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
