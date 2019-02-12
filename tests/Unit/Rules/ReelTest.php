<?php

namespace Tests\Unit\Rules;

use App\Rules\Reel;
use Tests\TestCase;

class ReelTest extends TestCase
{
    /**
     * @test
     * @covers \App\Rules\Reel::passes
     */
    public function valid_youtube()
    {
        $result = $this->app['validator']->make(
            ['reel' => 'https://www.youtube.com/embed/G8S81CEBdNs'],
            ['reel' => ['required', 'string', new Reel(),],]
        );

        $this->assertTrue($result->passes());
    }

    /**
     * @test
     * @covers \App\Rules\Reel::passes
     */
    public function valid_vimeo()
    {
        $result = $this->app['validator']->make(
            ['reel' => 'https://player.vimeo.com/video/197535359'],
            ['reel' => ['required', 'string', new Reel(),],]
        );

        $this->assertTrue($result->passes());
    }

    /**
     * @test
     * @covers \App\Rules\Reel::passes
     */
    public function invalid()
    {
        $result = $this->app['validator']->make(
            ['reel' => 'https://some-invalid-reel.com/invalid'],
            [
                'reel' => [
                    'required',
                    'string',
                    new Reel(),
                ],
            ]
        );

        $this->assertFalse($result->passes());
        $this->assertEquals(
            'The reel must be a valid Reel.',
            $result->errors()->first()
        );
    }
}
