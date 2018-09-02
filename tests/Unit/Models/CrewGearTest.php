<?php

namespace Tests\Unit\Models;

use App\Models\Crew;
use App\Models\CrewGear;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrewGearTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setup();

        $this->crew = factory(Crew::class)->create();
    }

    /**
     * @test
     */
    public function crew()
    {
        // when
        $crewGear = factory(CrewGear::class)
            ->create(['crew_id' => $this->crew->id]);

        // then
        $this->assertEquals($this->crew->id, $crewGear->crew->id);
    }
}
