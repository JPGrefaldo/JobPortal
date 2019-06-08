<?php

namespace Tests\Unit\Utils;

use App\Rules\Email;
use Tests\TestCase;

class EmailTest extends TestCase
{
    /**
     * @test
     * @covers \App\Rules\Email::passes
     */
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
}
