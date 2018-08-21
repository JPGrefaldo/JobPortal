<?php

namespace Tests\Unit\Models;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\CrewReel;
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
        $position = factory(Position::class)->create();
        $crew = factory(Crew::class)->create();
        $crewPosition = factory(CrewPosition::class)->make();

        // when
        $crew->positions()->attach($position, [
            'details' => $crewPosition->details,
            'union_description' => $crewPosition->union_description
        ]);

        // then
        $this->assertEquals($position->id, $crew->positions->first()->id);
        $this->assertDatabaseHas('crew_positions', [
            'crew_id' => $crew->id,
            'position_id' => $position->id,
            'details' => $crewPosition->details,
            'union_description' => $crewPosition->union_description
        ]);
    }

    /**
     * @test
     */
    public function reels()
    {
        // given
        $crew = factory(Crew::class)->create();

        // when
        $reels = factory(CrewReel::class, 3)->create(['crew_id' => $crew->id]);

        // then
        $this->assertCount(3, $crew->reels);
    }

    /**
     * @test
     */
    public function applyFor()
    {
        // given
        $position = factory(Position::class)->create();
        $crew = factory(Crew::class)->create();
        $crewPosition = factory(CrewPosition::class)->make();

        // when
        $crew->applyFor($position, $crewPosition);

        // then
        $this->assertEquals($position->id, $crew->positions->first()->id);
        $this->assertDatabaseHas('crew_positions', [
            'crew_id' => $crew->id,
            'position_id' => $position->id,
            'details' => $crewPosition->details,
            'union_description' => $crewPosition->union_description
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
