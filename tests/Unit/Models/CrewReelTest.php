<?php

namespace Tests\Unit\Models;

use App\Models\Crew;
use App\Models\CrewReel;
use App\Utils\UrlUtils;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrewReelTest extends TestCase
{
    use RefreshDatabase;

    protected $crew;
    protected $crewReel;

    public function setUp(): void
    {
        parent::setUp();

        $this->crew = factory(Crew::class)->create();
        $this->crewReel = factory(CrewReel::class)->create([
            'crew_id' => $this->crew->id,
        ]);
    }

    /**
     * @test
     * @covers \App\Models\CrewReel::crew
     */
    public function crew()
    {
        $this->assertEquals(
            $this->crew->id,
            $this->crewReel->crew->id
        );
    }

    /**
     * @test
     * @covers \App\Models\CrewReel::getPathAttribute
     */
    public function path_with_url()
    {
        $url = 'https://www.youtube.com/watch?v=2-_rLbU6zJo';

        $reel = factory(CrewReel::class)->create([
            'path'  => $url,
        ]);

        $this->assertEquals(
            $url,
            $reel->path
        );
    }

    /**
     * @test
     * @covers \App\Models\CrewReel::getPathAttribute
     */
    public function path_with_s3()
    {
        $url = '123345/reel/test.mp4';

        $reel = factory(CrewReel::class)->create([
            'path'  => $url,
        ]);

        $this->assertEquals(
            UrlUtils::getS3Url() . $url,
            $reel->path
        );
    }
}
