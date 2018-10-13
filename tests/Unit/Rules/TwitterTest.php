<?php

namespace Tests\Unit\Rules;

use App\Rules\Twitter;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TwitterTest extends TestCase
{
    /**
     * @test
     * @covers \App\Rules\Twitter::passes
     */
    public function valid()
    {
        $result = $this->app['validator']->make(
            ['twitter' => 'https://twitter.com/casting_america'],
            [
                'twitter' => [
                    'required',
                    'string',
                    new Twitter(),
                ],
            ]
        );

        $this->assertTrue($result->passes());
    }

    /**
     * @test
     * @covers \App\Rules\Twitter::passes
     */
    public function invalid()
    {
        $result = $this->app['validator']->make(
            ['twitter' => 'https://invalid-twitter.com/something'],
            [
                'twitter' => [
                    'required',
                    'string',
                    new Twitter(),
                ],
            ]
        );

        $this->assertFalse($result->passes());
        $this->assertEquals(
            'twitter must be a valid Twitter URL.',
            $result->errors()->first()
        );
    }
}
