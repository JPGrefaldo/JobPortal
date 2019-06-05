<?php

namespace Tests\Unit\Models;

use App\Models\SocialLinkType;
use Tests\TestCase;

class SocialLinkTypeTest extends TestCase
{
    /**
     * @test
     * @covers  \App\Models\SocialLinkType::getSlugAttribute
     */
    public function get_slug_attribute()
    {
        $this->assertEquals(
            'imdb',
            with(new SocialLinkType(['name' => 'IMDB']))->slug
        );

        $this->assertEquals(
            'google_plus',
            with(new SocialLinkType(['name' => 'Google Plus']))->slug
        );

        $this->assertEquals(
            'facebook',
            with(new SocialLinkType(['name' => 'Facebook']))->slug
        );
    }
}
