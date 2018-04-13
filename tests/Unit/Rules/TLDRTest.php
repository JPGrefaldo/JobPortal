<?php

namespace Tests\Unit\Utils;

use App\Rules\TLDR;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TLDRTest extends TestCase
{
    /** @test */
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

    /** @test */
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
