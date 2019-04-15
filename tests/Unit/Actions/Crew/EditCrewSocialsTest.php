<?php

namespace Tests\Unit\Actions\Crew;

use Illuminate\Support\Arr;
use App\Actions\Crew\EditCrewSocials;
use App\Actions\Crew\StoreCrew;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class EditCrewSocialsTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Actions\Crew\EditCrewResume::execute
     */
    public function execute()
    {
        // given
        Storage::fake('s3');

        $user = $this->createUser();
        $createData = $this->getCreateData();

        app(StoreCrew::class)->execute($user, $createData);

        $crew = $user->crew;
        $data = $this->getUpdateData();

        // when
        app(EditCrewSocials::class)->execute($crew, $data);

        // then
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
     * @param array $customData
     *
     * @return array
     */
    public function getUpdateData($customData = [])
    {
        $data = [
            'bio'     => 'updated bio',
            'photo'   => UploadedFile::fake()->image('new-photo.png'),
            'resume'  => UploadedFile::fake()->create('new-resume.pdf'),
            'reel'    => 'https://www.youtube.com/embed/WI5AF1DCQlc',
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
            'bio'     => 'some bio',
            'photo'   => UploadedFile::fake()->image('photo.png'),
            'resume'  => UploadedFile::fake()->create('resume.pdf'),
            'reel'    => 'http://www.youtube.com/embed/G8S81CEBdNs',
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

        return $this->customizeData($data, $customData);
    }
}
