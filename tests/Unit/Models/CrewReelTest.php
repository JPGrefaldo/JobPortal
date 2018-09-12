<?php

namespace Tests\Unit\Models;

use App\Models\Crew;
use App\Models\CrewReel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrewReelTest extends TestCase
{
    use RefreshDatabase;

    protected $crew;
    protected $crewReel;

    public function setUp()
    {
        parent::setUp();

        $this->crew = factory(Crew::class)->create();
        $this->crewReel = factory(CrewReel::class)->create([
            'crew_id' => $this->crew->id
        ]);
    }

    /**
     * @test
     */
    public function crew()
    {
        $this->assertEquals($this->crew->id, $this->crewReel->crew->id);
    }
}
