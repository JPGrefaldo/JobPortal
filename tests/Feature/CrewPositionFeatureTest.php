<?php

namespace Tests\Feature;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewPositionFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

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
    public function crew_can_apply_for_a_position()
    {
        // $this->withoutExceptionHandling();
        // given
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->make()->toArray();

        // when
        $response = $this
            ->actingAs($this->user)
            ->post(
                route('crew_position.store', $position),
                array_only($crewPosition, ['details', 'union_description'])
            );

        // then
        $this->assertDatabaseHas('crew_position', [
            'crew_id'     => $this->crew->id,
            'position_id' => $position->id,
            'details' => $crewPosition['details'],
            'union_description' => $crewPosition['union_description'],
        ]);
    }
}
