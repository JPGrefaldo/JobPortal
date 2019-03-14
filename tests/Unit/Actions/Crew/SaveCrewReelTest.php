<?php

namespace Tests\Unit\Actions\Crew;

use App\Actions\Crew\SaveCrewReel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class SaveCrewReelTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp()
    {
        parent::setUp();

        $user = $this->createCrew();
        $this->crew = $user->crew;
    }

    /**
     * @test
     * @covers \App\Actions\Crew\SaveCrewReel::execute
     */
    public function youtube_is_formatted_before_stored()
    {
        // given
        $data = [
            'reel' => 'https://www.youtube.com/watch?v=2-_rLbU6zJo',
        ];

        // when
        app(SaveCrewReel::class)->execute($this->crew, $data);

        // then
        $this->assertDatabaseHas('crew_reels', [
            'crew_id' => $this->crew->id,
            'path' => 'https://www.youtube.com/embed/2-_rLbU6zJo',
            'general' => true,
            'crew_position_id' => null,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\SaveCrewReel::execute
     */
    public function vimeo_is_formatted_before_stored()
    {
        // given
        $data = [
            'reel' => 'https://vimeo.com/230046783',
        ];

        // when
        app(SaveCrewReel::class)->execute($this->crew, $data);

        // then
        $this->assertDatabaseHas('crew_reels', [
            'crew_id' => $this->crew->id,
            'path' => 'https://player.vimeo.com/video/230046783',
            'general' => true,
            'crew_position_id' => null,
        ]);
    }
}