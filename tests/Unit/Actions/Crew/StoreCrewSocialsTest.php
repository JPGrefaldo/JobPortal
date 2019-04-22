<?php

namespace Tests\Unit\Actions\Crew;

use App\Actions\Crew\StoreCrewSocials;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\Support\CreatesCrewModel;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class StoreCrewSocialsTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        CreatesCrewModel;

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewSocials::execute
     */
    public function execute()
    {
        $models = $this->createCompleteCrew();

        app(StoreCrewSocials::class)->execute($models['crew'], $this->getUpdateCrewData());

        $this->assertCount(8, $models['crew']->socials);
        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $models['crew']->id,
            'social_link_type_id' => SocialLinkTypeID::FACEBOOK,
            'url'                 => 'https://www.facebook.com/new-castingcallsamerica/',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $models['crew']->id,
            'social_link_type_id' => SocialLinkTypeID::TWITTER,
            'url'                 => 'https://twitter.com/new-casting_america',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $models['crew']->id,
            'social_link_type_id' => SocialLinkTypeID::YOUTUBE,
            'url'                 => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJwNEW',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $models['crew']->id,
            'social_link_type_id' => SocialLinkTypeID::IMDB,
            'url'                 => 'http://www.imdb.com/name/nm0000134/-updated',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $models['crew']->id,
            'social_link_type_id' => SocialLinkTypeID::TUMBLR,
            'url'                 => 'http://new-updated.tumblr.com',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $models['crew']->id,
            'social_link_type_id' => SocialLinkTypeID::VIMEO,
            'url'                 => 'https://vimeo.com/new-mackevision',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $models['crew']->id,
            'social_link_type_id' => SocialLinkTypeID::INSTAGRAM,
            'url'                 => 'https://www.instagram.com/new-castingamerica/',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $models['crew']->id,
            'social_link_type_id' => SocialLinkTypeID::PERSONAL_WEBSITE,
            'url'                 => 'https://new-castingcallsamerica.com',
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewSocials::execute
     */
    public function execute_new_user()
    {
        $crew = $this->createCrew()->crew;
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

        app(StoreCrewSocials::class)->execute($crew, $data);

        $this->assertCount(8, $crew->socials);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $crew->id,
            'social_link_type_id' => SocialLinkTypeID::FACEBOOK,
            'url'                 => 'https://www.facebook.com/castingcallsamerica/',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $crew->id,
            'social_link_type_id' => SocialLinkTypeID::TWITTER,
            'url'                 => 'https://twitter.com/casting_america',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $crew->id,
            'social_link_type_id' => SocialLinkTypeID::YOUTUBE,
            'url'                 => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJw',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $crew->id,
            'social_link_type_id' => SocialLinkTypeID::IMDB,
            'url'                 => 'http://www.imdb.com/name/nm0000134/',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $crew->id,
            'social_link_type_id' => SocialLinkTypeID::TUMBLR,
            'url'                 => 'http://test.tumblr.com',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $crew->id,
            'social_link_type_id' => SocialLinkTypeID::VIMEO,
            'url'                 => 'https://vimeo.com/mackevision',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $crew->id,
            'social_link_type_id' => SocialLinkTypeID::INSTAGRAM,
            'url'                 => 'https://www.instagram.com/castingamerica/',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $crew->id,
            'social_link_type_id' => SocialLinkTypeID::PERSONAL_WEBSITE,
            'url'                 => 'https://castingcallsamerica.com',
        ]);
    }
}
