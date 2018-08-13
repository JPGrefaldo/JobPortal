<?php namespace Tests\Feature;

use App\Models\Crew;
use App\Models\Position;
use App\Models\CrewPosition;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;

class CrewPositionFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh, WithFaker;

    /**
     * @test
     */
    public function crew_can_apply_for_a_position()
    {
        // $this->withoutExceptionHandling();
        // given
        $crew     = factory(Crew::class)->states('withRole')->create();
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->make();

        // when
        $response = $this
            ->actingAs($crew->user)
            ->post(route('crew_position.store', $position), [
                'details' => $crewPosition->details,
                'union_description' => $crewPosition->union_description,
                ]);

        // then
        $this->assertDatabaseHas('crew_positions', [
            'crew_id'     => $crew->id,
            'position_id' => $position->id,
            'details' => $crewPosition->details,
            'union_description' => $crewPosition->union_description,
        ]);
    }
}
