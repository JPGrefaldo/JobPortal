<?php

namespace Tests\Unit\Models;

use App\Models\Crew;
use App\Models\CrewResume;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrewResumeTest extends TestCase
{
    use RefreshDatabase;

    protected $crew;
    protected $crewResume;

    public function setUp(): void
    {
        parent::setUp();

        $this->crew = factory(Crew::class)->create();
        $this->crewResume = factory(CrewResume::class)->create([
            'crew_id' => $this->crew->id,
        ]);
    }

    /**
     * @test
     * @covers \App\Models\CrewResume::crew
     */
    public function crew()
    {
        $this->assertEquals(
            $this->crew->id,
            $this->crewResume->crew->id
        );
    }
}
