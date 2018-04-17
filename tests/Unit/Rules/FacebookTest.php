<?php

namespace Tests\Unit\Rules;

use App\Rules\Facebook;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FacebookTest extends TestCase
{
    /** @test */
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
            ]);

        $this->assertTrue($result->passes());
    }

    /** @test */
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
            ]);

        $this->assertFalse($result->passes());
        $this->assertEquals(
            'facebook must be a valid Facebook URL.',
            $result->errors()->first()
        );
    }
}
