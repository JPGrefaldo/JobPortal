<?php

namespace Tests\Unit\Rules;

use App\Rules\Vimeo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VimeoTest extends TestCase
{
    /**
     * @test
     * @covers \App\Rules\Vimeo::passes
     */
    public function valid()
    {
        $result = $this->app['validator']->make(
            ['vimeo' => 'https://vimeo.com/mackevision'],
            [
                'vimeo' => [
                    'required',
                    'string',
                    new Vimeo(),
                ],
            ]
        );

        $this->assertTrue($result->passes());
    }

    /**
     * @test
     * @covers \App\Rules\Vimeo::passes
     */
    public function valid_player()
    {
        $result = $this->app['validator']->make(
            ['vimeo' => 'https://player.vimeo.com/video/197535359'],
            [
                'vimeo' => [
                    'required',
                    'string',
                    new Vimeo(),
                ],
            ]
        );

        $this->assertTrue($result->passes());
    }

    /**
     * @test
     * @covers \App\Rules\Vimeo::passes
     */
    public function invalid()
    {
        $result = $this->app['validator']->make(
            ['vimeo' => 'https://invalid-vimeo.com/something'],
            [
                'vimeo' => [
                    'required',
                    'string',
                    new Vimeo(),
                ],
            ]
        );

        $this->assertFalse($result->passes());
        $this->assertEquals(
            'vimeo must be a valid Vimeo URL.',
            $result->errors()->first()
        );
    }
}
