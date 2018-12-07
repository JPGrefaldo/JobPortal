<?php

namespace Tests\Unit\Actions\Crew;


use App\Actions\Crew\GetCrewPositionByPosition;
use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class GetCrewPositionByPositionTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var \App\Actions\Crew\GetCrewPositionByPosition
     */
    public $service;

    public function setUp()
    {
        parent::setup();
        $this->service = app(GetCrewPositionByPosition::class);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\GetCrewPositionByPosition::execute
     */
    public function execute()
    {
        $user = $this->createCrew();
        $crew = factory(Crew::class)->create([
            'user_id' => $user->id,
        ]);
        $position = Position::inRandomOrder()->get()->first();

        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id'     => $crew->id,
            'position_id' => $position,
        ]);

        $return = $this->service->execute($user, $position);

        $this->assertEquals($crewPosition->id, $return->id);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\GetCrewPositionByPosition::execute
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function execute_no_valid_position()
    {
        $user = $this->createCrew();
        $crew = factory(Crew::class)->create([
            'user_id' => $user->id,
        ]);
        $position = Position::inRandomOrder()->get()->first();

        $this->service->execute($user, $position);
    }
}