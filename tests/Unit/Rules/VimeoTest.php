<?php

namespace Tests\Unit\Rules;

use App\Rules\Vimeo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VimeoTest extends TestCase
{
    /** @test */
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

    /** @test */
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
