<?php

namespace Tests\Unit;

use App\Models\SocialLinkType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SocialLinkTypeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function scopeByCode()
    {
        // given
        factory(SocialLinkType::class)->create(['name' => 'Google Plus']);

        // when
        $socialLinkType = SocialLinkType::byCode('google_plus')->first();

        // then
        $this->assertInstanceOf(SocialLinkType::class, $socialLinkType);
        $this->assertEquals('Google Plus', $socialLinkType->name);
    }
}
