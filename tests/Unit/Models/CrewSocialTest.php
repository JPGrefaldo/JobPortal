<?php

namespace Tests\Unit\Models;

use App\Models\Crew;
use App\Models\CrewSocial;
use App\Models\SocialLinkType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrewSocialTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @covers \App\Models\CrewSocial::crew
     */
    public function crew()
    {
        $crew = factory(Crew::class)->create();
        $crewSocial = factory(CrewSocial::class)->create([
            'crew_id' => $crew->id,
        ]);
        $this->assertEquals($crew->bio, $crewSocial->crew->bio);
    }

    /**
     * @test
     * @covers \App\Models\CrewSocial::socialLinkType
     */
    public function socialLinkType()
    {
        $socialLinkType = factory(SocialLinkType::class)->create();
        $crewSocial = factory(CrewSocial::class)->create([
            'social_link_type_id' => $socialLinkType->id,
        ]);

        $this->assertEquals(
            $socialLinkType->url,
            $crewSocial->socialLinkType->url
        );
    }
}
