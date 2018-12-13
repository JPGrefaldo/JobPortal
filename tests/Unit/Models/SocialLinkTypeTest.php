<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\SocialLinkType;

class SocialLinkTypeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function get_slug_attribute()
    {
        $socialLinkType = factory(SocialLinkType::class)->create();

        $this->assertEquals('imdb',
            with(SocialLinkType::class([name=>'IMDB']))->slug);

        $this->assertEquals('google_plus',
            with(SocialLinkType::class([name=>'Google Plus']))->slug);

        $this->assertEquals('facebook',
            with(SocialLinkType::class([name=>'Facebook']))->slug);
    }
}
