<?php

namespace Tests\Unit\Rules;

use App\Rules\IMDB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IMDBTest extends TestCase
{
    /** @test */
    public function valid()
    {
        $result = $this->app['validator']->make(
            ['imdb' => 'http://www.imdb.com/name/nm0000134/'],
            [
                'imdb' => [
                    'required',
                    'string',
                    new IMDB(),
                ],
            ]
        );

        $this->assertTrue($result->passes());
    }

    /** @test */
    public function invalid()
    {
        $result = $this->app['validator']->make(
            ['imdb' => 'https://invalid-imdb.com/something'],
            [
                'imdb' => [
                    'required',
                    'string',
                    new IMDB(),
                ],
            ]
        );

        $this->assertFalse($result->passes());
        $this->assertEquals(
            'imdb must be a valid IMDB URL.',
            $result->errors()->first()
        );
    }
}
