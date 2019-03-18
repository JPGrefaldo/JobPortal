<?php

namespace Tests\Unit\Actions\Crew;

use App\Actions\Crew\SaveCrewSocials;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class SaveCrewSocialTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp()
    {
        parent::setUp();

        $user = $this->createCrew();
        $this->crew = $user->crew;
    }

    /**
     * @test
     * @covers \App\Actions\Crew\SaveCrewSocials::execute
     */
    public function execute()
    {
        // given
        $crew = $this->crew;
        $data = [
            'socials' => [
                'facebook'         => [
                    'url' => 'https://www.facebook.com/castingcallsamerica/',
                    'id'  => SocialLinkTypeID::FACEBOOK,
                ],
                'twitter'          => [
                    'url' => 'https://twitter.com/casting_america',
                    'id'  => SocialLinkTypeID::TWITTER,
                ],
                'youtube'          => [
                    'url' => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJw',
                    'id'  => SocialLinkTypeID::YOUTUBE,
                ],
                'imdb'             => [
                    'url' => 'http://www.imdb.com/name/nm0000134/',
                    'id'  => SocialLinkTypeID::IMDB,
                ],
                'tumblr'           => [
                    'url' => 'http://test.tumblr.com',
                    'id'  => SocialLinkTypeID::TUMBLR,
                ],
                'vimeo'            => [
                    'url' => 'https://vimeo.com/mackevision',
                    'id'  => SocialLinkTypeID::VIMEO,
                ],
                'instagram'        => [
                    'url' => 'https://www.instagram.com/castingamerica/',
                    'id'  => SocialLinkTypeID::INSTAGRAM,
                ],
                'personal_website' => [
                    'url' => 'https://castingcallsamerica.com',
                    'id'  => SocialLinkTypeID::PERSONAL_WEBSITE,
                ],
            ],
        ];

        // when
        app(SaveCrewSocials::class)->execute($crew, $data);

        // then
        $this->assertCount(8, $crew->socials);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id' => $crew->id,
            'social_link_type_id' => SocialLinkTypeID::FACEBOOK,
            'url' => 'https://www.facebook.com/castingcallsamerica/',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id' => $crew->id,
            'social_link_type_id' => SocialLinkTypeID::TWITTER,
            'url' => 'https://twitter.com/casting_america',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id' => $crew->id,
            'social_link_type_id' => SocialLinkTypeID::YOUTUBE,
            'url' => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJw',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id' => $crew->id,
            'social_link_type_id' => SocialLinkTypeID::IMDB,
            'url' => 'http://www.imdb.com/name/nm0000134/',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id' => $crew->id,
            'social_link_type_id' => SocialLinkTypeID::TUMBLR,
            'url' => 'http://test.tumblr.com',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id' => $crew->id,
            'social_link_type_id' => SocialLinkTypeID::VIMEO,
            'url' => 'https://vimeo.com/mackevision',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id' => $crew->id,
            'social_link_type_id' => SocialLinkTypeID::INSTAGRAM,
            'url' => 'https://www.instagram.com/castingamerica/',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id' => $crew->id,
            'social_link_type_id' => SocialLinkTypeID::PERSONAL_WEBSITE,
            'url' => 'https://castingcallsamerica.com',
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\SaveCrewSocial::execute
     */
    public function youtube_is_formatted_before_stored()
    {
        // given
        $data = [
            'socials' => [
                'youtube' => [
                    'url' => 'https://www.youtube.com/watch?v=G8S81CEBdNs',
                    'id' => SocialLinkTypeID::YOUTUBE,
                ],
            ],
        ];

        // when
        app(SaveCrewSocials::class)->execute($this->crew, $data);

        // then
        $this->assertDatabaseHas('crew_socials', [
            'crew_id' => $this->crew->id,
            'social_link_type_id' => SocialLinkTypeID::YOUTUBE,
            'url' => 'https://www.youtube.com/embed/G8S81CEBdNs',
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\SaveCrewSocial::execute
     */
    public function vimeo_is_formatted_before_stored()
    {
        // given
        $data = [
            'socials' => [
                'vimeo' => [
                    'url' => 'https://vimeo.com/230046783',
                    'id' => SocialLinkTypeID::VIMEO,
                ],
            ],
        ];

        // when
        app(SaveCrewSocials::class)->execute($this->crew, $data);

        // then
        $this->assertDatabaseHas('crew_socials', [
            'crew_id' => $this->crew->id,
            'social_link_type_id' => SocialLinkTypeID::VIMEO,
            'url' => 'https://player.vimeo.com/video/230046783',
        ]);
    }
}
