<?php

namespace Tests\Unit\Rules;

use App\Rules\GooglePlus;
use Tests\TestCase;

class GooglePlusTest extends TestCase
{
    /**
     * @test
     * @covers \App\Rules\GooglePlus::passes
     */
    public function valid()
    {
        $result = $this->app['validator']->make(
            ['google_plus' => 'https://plus.google.com/+marvel'],
            [
                'google_plus' => [
                    'required',
                    'string',
                    new GooglePlus(),
                ],
            ]
        );

        $this->assertTrue($result->passes());
    }

    /**
     * @test
     * @covers \App\Rules\GooglePlus::passes
     */
    public function invalid()
    {
        $result = $this->app['validator']->make(
            ['google_plus' => 'https://invalid-gplus.com/something'],
            [
                'google_plus' => [
                    'required',
                    'string',
                    new GooglePlus(),
                ],
            ]
        );

        $this->assertFalse($result->passes());
        $this->assertEquals(
            'google plus must be a valid Google Plus URL.',
            $result->errors()->first()
        );
    }
}
