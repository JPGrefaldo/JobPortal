<?php

namespace Tests\Unit\Rules;

use App\Rules\Tumblr;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TumblrTest extends TestCase
{
    /**
     * @test
     * @covers \App\Rules\Tumblr::passes
     */
    public function valid()
    {
        $result = $this->app['validator']->make(
            ['tumblr' => 'http://test.tumblr.com'],
            [
                'tumblr' => [
                    'required',
                    'string',
                    new Tumblr(),
                ],
            ]
        );

        $this->assertTrue($result->passes());
    }

    /**
     * @test
     * @covers \App\Rules\Tumblr::passes
     */
    public function valid_domain()
    {
        $result = $this->app['validator']->make(
            ['tumblr' => 'http://fridgemania.com'],
            [
                'tumblr' => [
                    'required',
                    'string',
                    new Tumblr(),
                ],
            ]
        );

        $this->assertTrue($result->passes());
    }

    /**
     * @test
     * @covers \App\Rules\Tumblr::passes
     */
    public function invalid()
    {
        $result = $this->app['validator']->make(
            ['tumblr' => 'http://test.tumblr.test'],
            [
                'tumblr' => [
                    'required',
                    'string',
                    new Tumblr(),
                ],
            ]
        );

        $this->assertFalse($result->passes());
        $this->assertEquals(
            'tumblr must be a valid Tumblr URL.',
            $result->errors()->first()
        );
    }
}
