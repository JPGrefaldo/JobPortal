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
     */
    public function crew()
    {
        $crew = factory(Crew::class)->create();
        $crewSocial = factory(CrewSocial::class)->create([
            'crew_id' => $crew->id
        ]);
        $this->assertEquals($crew->id, $crewSocial->crew->id);
    }

    /**
     * @test
     */
    public function socialLinkType()
    {
        // when
        $socialLinkType = factory(SocialLinkType::class)->create();
        $crewSocial = factory(CrewSocial::class)->create([
            'social_link_type_id' => $socialLinkType->id
        ]);

        // then
        $this->assertEquals(
            $socialLinkType->id,
            $crewSocial->socialLinkType->id
        );
    }
}
