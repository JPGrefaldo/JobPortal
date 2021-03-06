<?php

namespace Tests\Unit\Utils;

use App\Rules\YouTube;
use Tests\TestCase;

class YouTubeTest extends TestCase
{
    /**
     * @test
     * @covers \App\Rules\YouTube::passes
     */
    public function valid_youtube()
    {
        $this->assertTrue($this->app['validator']->make([
            'youtube' => 'https://www.youtube.com/embed/G8S81CEBdNs',
        ], [
            'youtube' => [
                'required',
                'string',
                new YouTube(),
            ],
        ])->passes());
    }

    /**
     * @test
     * @covers \App\Rules\YouTube::passes
     */
    public function invalid_youtube()
    {
        $result = $this->app['validator']->make([
            'youtube' => 'https://vimeo.com/channels/staffpicks/263945041',
        ], [
            'youtube' => [
                'required',
                'string',
                new YouTube(),
            ],
        ]);

        $this->assertFalse($result->passes());
        $this->assertEquals('youtube must be a valid YouTube URL.', $result->errors()->first());
    }
}
