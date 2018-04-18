<?php

namespace Tests\Unit\Rules;

use App\Rules\Instagram;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InstagramTest extends TestCase
{
    /** @test */
    public function valid()
    {
        $result = $this->app['validator']->make(
            ['instagram' => 'https://www.instagram.com/castingamerica/'],
            [
                'instagram' => [
                    'required',
                    'string',
                    new Instagram(),
                ],
            ]
        );

        $this->assertTrue($result->passes());
    }

    /** @test */
    public function invalid()
    {
        $result = $this->app['validator']->make(
            ['instagram' => 'https://invalid-twitter.com/something'],
            [
                'instagram' => [
                    'required',
                    'string',
                    new Instagram(),
                ],
            ]
        );

        $this->assertFalse($result->passes());
        $this->assertEquals(
            'instagram must be a valid Instagram URL.',
            $result->errors()->first()
        );
    }
}
