<?php

namespace Tests\Unit\Actions\Crew;

use App\Actions\Crew\StoreCrewSocials;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class StoreCrewSocialsTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewSocials::execute
     */
    public function execute()
    {
        $user = $this->createCrew();

        $user->crew->socials()->createMany($this->getCreateData()['socials']);

        app(StoreCrewSocials::class)->execute($user->crew, $this->getUpdateData());

        $this->assertCount(8, $user->crew->socials);
        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $user->crew->id,
            'social_link_type_id' => SocialLinkTypeID::FACEBOOK,
            'url'                 => 'https://www.facebook.com/new-castingcallsamerica/',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $user->crew->id,
            'social_link_type_id' => SocialLinkTypeID::TWITTER,
            'url'                 => 'https://twitter.com/new-casting_america',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $user->crew->id,
            'social_link_type_id' => SocialLinkTypeID::YOUTUBE,
            'url'                 => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJwNEW',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $user->crew->id,
            'social_link_type_id' => SocialLinkTypeID::IMDB,
            'url'                 => 'http://www.imdb.com/name/nm0000134/-updated',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $user->crew->id,
            'social_link_type_id' => SocialLinkTypeID::TUMBLR,
            'url'                 => 'http://new-updated.tumblr.com',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $user->crew->id,
            'social_link_type_id' => SocialLinkTypeID::VIMEO,
            'url'                 => 'https://vimeo.com/new-mackevision',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $user->crew->id,
            'social_link_type_id' => SocialLinkTypeID::INSTAGRAM,
            'url'                 => 'https://www.instagram.com/new-castingamerica/',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $user->crew->id,
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
        // given
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

        // when
        app(StoreCrewSocials::class)->execute($crew, $data);

        // then
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

    /**
     * @param array $customData
     *
     * @return array
     */
    public function getUpdateData($customData = [])
    {
        $data = [
            'socials' => [
                'facebook'         => [
                    'url' => 'https://www.facebook.com/new-castingcallsamerica/',
                    'id'  => SocialLinkTypeID::FACEBOOK,
                ],
                'twitter'          => [
                    'url' => 'https://twitter.com/new-casting_america',
                    'id'  => SocialLinkTypeID::TWITTER,
                ],
                'youtube'          => [
                    'url' => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJwNEW',
                    'id'  => SocialLinkTypeID::YOUTUBE,
                ],
                'imdb'             => [
                    'url' => 'http://www.imdb.com/name/nm0000134/-updated',
                    'id'  => SocialLinkTypeID::IMDB,
                ],
                'tumblr'           => [
                    'url' => 'http://new-updated.tumblr.com',
                    'id'  => SocialLinkTypeID::TUMBLR,
                ],
                'vimeo'            => [
                    'url' => 'https://vimeo.com/new-mackevision',
                    'id'  => SocialLinkTypeID::VIMEO,
                ],
                'instagram'        => [
                    'url' => 'https://www.instagram.com/new-castingamerica/',
                    'id'  => SocialLinkTypeID::INSTAGRAM,
                ],
                'personal_website' => [
                    'url' => 'https://new-castingcallsamerica.com',
                    'id'  => SocialLinkTypeID::PERSONAL_WEBSITE,
                ],
            ],
        ];

        return $this->customizeData($data, $customData);
    }

    /**
     * @param $data
     * @param $customData
     *
     * @return mixed
     */
    protected function customizeData($data, $customData)
    {
        foreach ($customData as $key => $value) {
            Arr::set($data, $key, $value);
        }

        return $data;
    }

    /**
     * @param array $customData
     *
     * @return array
     */
    public function getCreateData($customData = [])
    {
        $data = [
            'socials' => [
                'facebook'         => [
                    'url'                  => 'https://www.facebook.com/castingcallsamerica/',
                    'social_link_type_id'  => SocialLinkTypeID::FACEBOOK,
                ],
                'twitter'          => [
                    'url'                  => 'https://twitter.com/casting_america',
                    'social_link_type_id'  => SocialLinkTypeID::TWITTER,
                ],
                'youtube'          => [
                    'url'                  => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJw',
                    'social_link_type_id'  => SocialLinkTypeID::YOUTUBE,
                ],
                'imdb'             => [
                    'url'                  => 'http://www.imdb.com/name/nm0000134/',
                    'social_link_type_id'  => SocialLinkTypeID::IMDB,
                ],
                'tumblr'           => [
                    'url'                  => 'http://test.tumblr.com',
                    'social_link_type_id'  => SocialLinkTypeID::TUMBLR,
                ],
                'vimeo'            => [
                    'url'                  => 'https://vimeo.com/mackevision',
                    'social_link_type_id'  => SocialLinkTypeID::VIMEO,
                ],
                'instagram'        => [
                    'url'                  => 'https://www.instagram.com/castingamerica/',
                    'social_link_type_id'  => SocialLinkTypeID::INSTAGRAM,
                ],
                'personal_website' => [
                    'url'                  => 'https://castingcallsamerica.com',
                    'social_link_type_id'  => SocialLinkTypeID::PERSONAL_WEBSITE,
                ],
            ],
        ];

        return $this->customizeData($data, $customData);
    }
}
