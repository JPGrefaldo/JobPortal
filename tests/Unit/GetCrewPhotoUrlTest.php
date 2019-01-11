<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetCrewPhotoUrlTest extends TestCase
{
    /**
     * @test
     * @covers  \App\Models\Crew::getPhotoUrlAttribute
     */
    public function get_photo_url_attribute()
    {
        $this->assertEquals(
            'https://s3-us-west-2.amazonaws.com/test.crewcalls.info/photo.png'
        );
    }
}
