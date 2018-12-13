<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\SocialLinkType;

class SocialLinkTypeTest extends TestCase
{
    /**
     * @test
     */
    public function get_slug_attribute()
    {
        $this->assertEquals('imdb',
            with(new SocialLinkType(['name'=>'IMDB']))->slug);

        $this->assertEquals('google_plus',
            with(new SocialLinkType(['name'=>'Google Plus']))->slug);

        $this->assertEquals('facebook',
            with(new SocialLinkType(['name'=>'Facebook']))->slug);
    }
}
