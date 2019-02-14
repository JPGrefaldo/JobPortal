<?php

namespace Tests\Unit\Utils;

use App\Rules\TLDR;
use Tests\TestCase;

class TLDRTest extends TestCase
{
    /**
     * @test
     * @covers \App\Rules\TLDR::passes
     */
    public function valid_tldr()
    {
        $this->assertTrue($this->app['validator']->make([
            'website' => 'https://castingcallsmaerica.com',
        ], [
            'website' => [
                'required',
                'string',
                new TLDR(),
            ],
        ])->passes());

        $this->assertTrue($this->app['validator']->make([
            'website' => 'https://bigtime.vip',
        ], [
            'website' => [
                'required',
                'string',
                new TLDR(),
            ],
        ])->passes());
    }

    /**
     * @test
     * @covers \App\Rules\TLDR::passes
     */
    public function invalid_tldr()
    {
        $result = $this->app['validator']->make([
            'website' => 'https://castingcallsmaerica.c4om',
        ], [
            'website' => [
                'required',
                'string',
                new TLDR(),
            ],
        ]);

        $this->assertFalse($result->passes());
        $this->assertEquals('The website is invalid.', $result->errors()->first());
    }
}
