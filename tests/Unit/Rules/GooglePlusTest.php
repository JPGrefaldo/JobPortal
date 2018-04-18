<?php

namespace Tests\Unit\Rules;

use App\Rules\GooglePlus;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GooglePlusTest extends TestCase
{
    /** @test */
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
            ]);

        $this->assertTrue($result->passes());
    }

    /** @test */
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
            ]);

        $this->assertFalse($result->passes());
        $this->assertEquals(
            'google plus must be a valid Google Plus URL.',
            $result->errors()->first()
        );
    }
}
