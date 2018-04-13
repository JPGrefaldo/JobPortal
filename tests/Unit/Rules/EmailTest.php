<?php

namespace Tests\Unit\Utils;

use App\Rules\Email;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailTest extends TestCase
{
    /** @test */
    public function valid_email()
    {
        $this->assertTrue($this->app['validator']->make([
            'email' => 'test@castingcallsamerica.com',
        ], [
            'email' => [
                'required',
                'string',
                new Email(),
            ],
        ])->passes());
    }

    /** @test */
    public function invalid_email()
    {
        $result = $this->app['validator']->make([
            'email' => 'test@blhadsfsdfglkasdkljklasjfglkjasdkflgakldfgjklaefjgl.com',
        ], [
            'email' => [
                'required',
                'string',
                new Email(),
            ],
        ]);

        $this->assertFalse($result->passes());
        $this->assertEquals('The email must be a valid email address.', $result->errors()->first());
    }
}
