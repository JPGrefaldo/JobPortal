<?php

namespace Tests\Unit\Rules;

use App\Rules\Facebook;
use Tests\TestCase;

class FacebookTest extends TestCase
{
    /**
     * @test
     * @covers \App\Rules\Facebook::passes
     */
    public function valid()
    {
        $result = $this->app['validator']->make(
            ['facebook' => 'https://www.facebook.com/castingcallsamerica/'],
            [
                'facebook' => [
                    'required',
                    'string',
                    new Facebook(),
                ],
            ]
        );

        $this->assertTrue($result->passes());
    }

    /**
     * @test
     * @covers \App\Rules\Facebook::passes
     */
    public function invalid()
    {
        $result = $this->app['validator']->make(
            ['facebook' => 'https://vimeo.com/channels/staffpicks/263945041'],
            [
                'facebook' => [
                    'required',
                    'string',
                    new Facebook(),
                ],
            ]
        );

        $this->assertFalse($result->passes());
        $this->assertEquals(
            'facebook must be a valid Facebook URL.',
            $result->errors()->first()
        );
    }
}
