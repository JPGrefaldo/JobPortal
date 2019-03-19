<?php

namespace Tests\Unit\Actions\Crew;

use App\Actions\Crew\EditCrewReel;
use App\Actions\Crew\StoreCrew;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class EditCrewReelTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Actions\Crew\EditCrewReel
     */
    public function blank_reel_can_be_updated_to_link()
    {
        // given
        Storage::fake('s3');

        $user = $this->createUser();
        $createData = $this->getCreateData([
            'reel' => null,
        ]);

        app(StoreCrew::class)->execute($user, $createData);

        $crew = $user->crew;
        $data = $this->getUpdateData();

        // when
        app(EditCrewReel::class)->execute($crew, $data);

        // then
        $this->assertDatabaseHas('crew_reels', [
            'crew_id'          => $user->crew->id,
            'path'             => 'https://www.youtube.com/embed/WI5AF1DCQlc',
            'general'          => true,
            'crew_position_id' => null,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\EditCrewReel::execute
     */
    public function blank_reel_can_be_updated_to_file()
    {
        // given
        Storage::fake('s3');

        $user = $this->createUser();
        $createData = $this->getCreateData([
            'reel' => null,
        ]);

        app(StoreCrew::class)->execute($user, $createData);

        $crew = $user->crew;
        $data = $this->getUpdateData([
            'reel' => UploadedFile::fake()->create('new-reel.mp4'),
        ]);

        // when
        app(EditCrewReel::class)->execute($crew, $data);

        // then
        $expectedPath = $crew->user->hash_id . '/reels/'. $data['reel']->hashName();

        Storage::disk('s3')->assertExists($expectedPath);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id'          => $user->crew->id,
            'path'             => $expectedPath,
            'general'          => true,
            'crew_position_id' => null,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\EditCrewReel::execute
     */
    public function link_reel_can_be_updated_to_link_reel()
    {
        // given
        Storage::fake('s3');

        $user = $this->createUser();
        $createData = $this->getCreateData();

        app(StoreCrew::class)->execute($user, $createData);

        $crew = $user->crew;
        $data = $this->getUpdateData();

        // when
        app(EditCrewReel::class)->execute($crew, $data);

        // then
        $this->assertDatabaseHas('crew_reels', [
            'crew_id'          => $user->crew->id,
            'path'             => 'https://www.youtube.com/embed/WI5AF1DCQlc',
            'general'          => true,
            'crew_position_id' => null,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\EditCrewReel::execute
     */
    public function reel_file_can_be_replaced_by_reel_file()
    {
        // given
        Storage::fake('s3');

        $user = $this->createUser();
        $createData = $this->getCreateData([
            'reel' => UploadedFile::fake()->create('old-reel.mp4'),
        ]);

        app(StoreCrew::class)->execute($user, $createData);

        $crew = $user->crew;
        $data = $this->getUpdateData([
            'reel' => UploadedFile::fake()->create('new-reel.mp4'),
        ]);
        $nonExpectedPath = $crew->user->hash_id . '/reels/'. $createData['reel']->hashName();

        // when
        app(EditCrewReel::class)->execute($crew, $data);

        // then
        Storage::disk('s3')->assertMissing($nonExpectedPath);

        $expectedPath = $crew->user->hash_id . '/reels/'. $data['reel']->hashName();

        Storage::disk('s3')->assertExists($expectedPath);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id'          => $user->crew->id,
            'path'             => $expectedPath,
            'general'          => true,
            'crew_position_id' => null,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\EditCrew::execute
     */
    public function reel_link_can_be_replaced_by_reel_file()
    {
        // given
        Storage::fake('s3');

        $user = $this->createUser();
        $createData = $this->getCreateData();

        app(StoreCrew::class)->execute($user, $createData);

        $crew = $user->crew;
        $data = $this->getUpdateData([
            'reel' => UploadedFile::fake()->create('new-reel.mp4'),
        ]);

        // when
        app(EditCrewReel::class)->execute($crew, $data);

        // then
        $expectedPath = $crew->user->hash_id . '/reels/'. $data['reel']->hashName();

        Storage::disk('s3')->assertExists($expectedPath);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id'          => $user->crew->id,
            'path'             => $expectedPath,
            'general'          => true,
            'crew_position_id' => null,
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
            array_set($data, $key, $value);
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
