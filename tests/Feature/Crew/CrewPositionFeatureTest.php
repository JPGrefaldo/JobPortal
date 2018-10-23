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
     * @covers \App\Http\Controllers\Crew::index
     */
    public function crew_can_see_all_positions()
    {
        // when
        $response = $this->actingAs($this->user)
            ->get(route('crew.endorsement.index'));

        // then
        Position::all()->each(function ($position) use ($response) {
            $response->assertSee(htmlspecialchars($position->name));
        });

        $response->assertSee('Apply');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew::create
     */
    public function crew_is_redirected_when_applying_for_applied_position()
    {
        // given
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $this->crew->id,
            'position_id' => $position->id
        ]);

        // when
        $response = $this->actingAs($this->user)
            ->get(route('crew.endorsement.position.create', $position));

        // then
        $response->assertRedirect(route('crew.endorsement.position.edit', $position));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew::store
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
                route('crew.endorsement.position.store', $position),
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

    /**
     * @test
     * @covers \App\Http\Controllers\Crew::edit
     */
    public function crew_can_see_edit_form_to_applied_position()
    {
        $this->withoutExceptionHandling();
        // given
        $appliedPosition = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $this->crew->id,
            'position_id' => $appliedPosition->id,
        ]);


        // when
        $response = $this
            ->actingAs($this->user)
            ->get(route('crew.endorsement.position.edit', $appliedPosition));


        // then
        $response->assertSee("Edit $appliedPosition->name position");
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew::edit
     */
    public function crew_is_redirected_when_trying_to_edit_non_applied_position()
    {
        $this->withoutExceptionHandling();
        // given
        $nonAppliedPosition = factory(Position::class)->create();

        // when
        $response = $this
            ->actingAs($this->user)
            ->get(route('crew.endorsement.position.edit', $nonAppliedPosition));


        // then
        $response->assertRedirect(route('crew.endorsement.position.create', $nonAppliedPosition));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew::destroy
     */
    public function crew_can_leave_a_position()
    {
        // given
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)
                ->create([
                    'crew_id' => $this->crew->id,
                    'position_id' => $position->id
                ]);

        // when
        $response = $this
            ->actingAs($this->user)
            ->delete(route('crew.endorsement.position.destroy', $position));

        // then
        $this->assertCount(0, CrewPosition::all());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew::destroy
     */
    public function crew_can_only_leave_applied_position()
    {
        // given
        $randomPosition = factory(Position::class)->create();
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)
                ->create([
                    'crew_id' => $this->crew->id,
                    'position_id' => $position->id
                ]);

        // when
        $response = $this
            ->actingAs($this->user)
            ->delete(route('crew.endorsement.position.destroy', $randomPosition));

        // then
        $this->assertCount(1, CrewPosition::all());
    }
}
