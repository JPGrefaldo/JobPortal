<?php

namespace Tests\Unit\Actions\Crew;

use Illuminate\Support\Arr;
use App\Actions\Crew\StoreCrewResume;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\CreatesCrewModel;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class StoreCrewResumeTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        CreatesCrewModel;

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewResume::execute
     */
    public function execute()
    {
        // given
        Storage::fake('s3');

        $models = $this->createCompleteCrew();

        $oldResumePath = $models['crew']->resumes()->where('general', true)->first()->path;

        Storage::disk('s3')->assertExists($oldResumePath);

        $data = $this->getUpdateData();

        app(StoreCrewResume::class)->execute($models['crew'], $data);

        $this->assertDatabaseHas('crew_resumes', [
            'crew_id'          => $models['crew']->id,
            'path'             => $models['user']->hash_id . '/resumes/' . $data['resume']->hashName(),
            'general'          => true,
            'crew_position_id' => null,
        ]);

        $resume = $models['crew']->refresh()->resumes->where('general', true)->first();
        Storage::disk('s3')->assertMissing($oldResumePath);
        Storage::disk('s3')->assertExists($resume->path);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewResume::execute
     */
    public function execute_new_user()
    {
        Storage::fake('s3');

        $models = $this->createCompleteCrew([
            'reel' => [
                'path' => '',
            ],
        ]);

        $resume = $models['crew']->refresh()->resumes->where('general', true)->first();

        $data = [
            'resume'  => UploadedFile::fake()->create('resume.pdf'),
        ];

        app(StoreCrewResume::class)->execute($models['crew'], $data);

        $this->assertDatabaseHas('crew_resumes', [
            'crew_id'          => $models['crew']->id,
            'path'             => $models['user']->hash_id . '/resumes/' . $data['resume']->hashName(),
            'general'          => true,
            'crew_position_id' => null,
        ]);

        $resume = $models['crew']->refresh()->resumes->where('general', true)->first();
        Storage::disk('s3')->assertExists($resume->path);
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
