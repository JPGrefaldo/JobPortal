<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\CrewsServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewsServicesTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var \App\Services\CrewsServices
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(CrewsServices::class);
    }

    /** @test */
    public function process_create()
    {
        Storage::fake();

        $user = factory(User::class)->create();

        $data = [
            'bio'     => 'some bio',
            'photo'   => UploadedFile::fake()->image('photo.png'),
            'resume'  => UploadedFile::fake()->create('resume.pdf'),
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
                'google_plus'      => [
                    'url' => 'https://plus.google.com/+marvel',
                    'id'  => SocialLinkTypeID::GOOGLE_PLUS,
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

        // assert crew data
        $crew = $this->service->processCreate($data, $user);

        $this->assertEquals($data['bio'], $crew->bio);
        Storage::assertExists($crew->photo);

        // assert general resume
        $resume = $crew->resumes->first();

        $this->assertEquals(1, $resume->general);
        Storage::assertExists($crew->resumes->first()->url);

        // assert that the socials has been created
        $crew->load('social.socialLinkType');

        $this->assertCount(9, $crew->social);

        foreach (array_keys($data['socials']) as $idx => $key) {
            // check if the crew social data is correct
            $crewSocial = $crew->social->get($idx);

            $this->assertEquals(
                [
                    $data['socials'][$key]['id'],
                    $data['socials'][$key]['url'],
                ],
                [
                    $crewSocial->social_link_type_id,
                    $crewSocial->url,
                ]
            );

            // check if the social link type is correct
            $this->assertEquals(
                str_replace('_', ' ', $key),
                strtolower($crewSocial->socialLinkType->name)
            );
        }
    }

    /** @test */
    public function create()
    {
        Storage::fake();

        $user = factory(User::class)->create();
        $data = [
            'user_id'   => $user->id,
            'bio'       => 'some bio',
            'photo'     => UploadedFile::fake()->image('photo.png'),
            'photo_dir' => $user->uiid,
        ];

        $crew = $this->service->create($data);

        $this->assertDatabaseHas('crews', [
            'id'      => $crew->id,
            'user_id' => $data['user_id'],
            'bio'     => $data['bio'],
            'photo'   => 'photos/' . $data['photo_dir'] . '/' . $data['photo']->hashName(),
        ]);

        Storage::assertExists($crew->photo);
    }

    /** @test */
    public function create_general_resume()
    {
        Storage::fake();

        $user       = factory(User::class)->create();
        $crew       = $this->service->create([
            'user_id'   => $user->id,
            'bio'       => 'some bio',
            'photo'     => UploadedFile::fake()->image('photo.png'),
            'photo_dir' => $user->uiid,
        ]);
        $resumeFile = UploadedFile::fake()->create('resume.pdf');

        $this->service->createGeneralResume($resumeFile, $crew);

        // assert data
        $resume = $crew->resumes->where('general', 1)->first();

        $this->assertArraySubset(
            [
                'url'     => 'resumes/' . $user->uuid . '/' . $resumeFile->hashName(),
                'crew_id' => $crew->id,
                'general' => 1,
            ],
            $resume->toArray()
        );

        // assert file exists
        Storage::assertExists($resume->url);
    }

    /** @test */
    public function create_socials()
    {
        Storage::fake();

        $user = factory(User::class)->create();
        $crew = $this->service->create([
            'user_id'   => $user->id,
            'bio'       => 'some bio',
            'photo'     => UploadedFile::fake()->image('photo.png'),
            'photo_dir' => $user->uiid,
        ]);
        $data = [
            'youtube' => [
                'url' => 'https://www.youtube.com/watch?v=2-_rLbU6zJo',
                'id'  => SocialLinkTypeID::YOUTUBE,
            ],
        ];

        $this->service->createSocials($data, $crew);

        $this->assertDatabaseHas('crew_social', [
            'crew_id'             => $crew->id,
            'social_link_type_id' => $data['youtube']['id'],
            'url'                 => 'https://www.youtube.com/embed/2-_rLbU6zJo',
        ]);
    }

    /** @test */
    public function process_update()
    {
        Storage::fake();

        $crew     = $this->service->processCreate(
            $this->getProcessCreateData(),
            factory(User::class)->create()
        );
        $resume   = $crew->resumes->where('general', 1)->first();
        $oldFiles = [
            'photo'  => $crew->photo,
            'resume' => $resume->url,
        ];
        $data     = $this->getProcessUpdateData();

        $crew = $this->service->processUpdate($data, $crew);

        // assert crew
        $this->assertArraySubset(
            [
                'bio'   => 'updated bio',
                'photo' => 'photos/' . $crew->user->uuid . '/' . $data['photo']->hashName(),
            ],
            $crew->toArray()
        );

        Storage::assertMissing($oldFiles['photo']);
        Storage::assertExists($crew->photo);

        // assert general resume
        $resume->refresh();

        $this->assertArraySubset(
            [
                'url'     => 'resumes/' . $crew->user->uuid . '/' . $data['resume']->hashName(),
                'crew_id' => $crew->id,
                'general' => 1,
            ],
            $resume->toArray()
        );
        Storage::assertMissing($oldFiles['resume']);
        Storage::assertExists($resume->url);

        // assert socials
        $this->assertCount(9, $crew->social);
        $this->assertArraySubset(
            [
                [
                    'url'                 => 'https://www.facebook.com/new-castingcallsamerica/',
                    'social_link_type_id' => SocialLinkTypeID::FACEBOOK,
                ],
                [
                    'url'                 => 'https://twitter.com/new-casting_america',
                    'social_link_type_id' => SocialLinkTypeID::TWITTER,
                ],
                [
                    'url'                 => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJwNEW',
                    'social_link_type_id' => SocialLinkTypeID::YOUTUBE,
                ],
                [
                    'url'                 => 'https://plus.google.com/+marvel-new',
                    'social_link_type_id' => SocialLinkTypeID::GOOGLE_PLUS,
                ],
                [
                    'url'                 => 'http://www.imdb.com/name/nm0000134/-updated',
                    'social_link_type_id' => SocialLinkTypeID::IMDB,
                ],
                [
                    'url'                 => 'http://new-updated.tumblr.com',
                    'social_link_type_id' => SocialLinkTypeID::TUMBLR,
                ],
                [
                    'url'                 => 'https://vimeo.com/new-mackevision',
                    'social_link_type_id' => SocialLinkTypeID::VIMEO,
                ],
                [
                    'url'                 => 'https://www.instagram.com/new-castingamerica/',
                    'social_link_type_id' => SocialLinkTypeID::INSTAGRAM,
                ],
                [
                    'url'                 => 'https://new-castingcallsamerica.com',
                    'social_link_type_id' => SocialLinkTypeID::PERSONAL_WEBSITE,
                ],
            ],
            $crew->social->toArray()
        );
    }

    /** @test */
    public function process_update_without_photo()
    {
        Storage::fake();

        $user         = factory(User::class)->create();
        $crew         = $this->service->create([
            'user_id'   => $user->id,
            'bio'       => 'some bio',
            'photo'     => UploadedFile::fake()->image('photo.png'),
            'photo_dir' => $user->uiid,
        ]);
        $data         = [
            'bio'     => 'new bio',
            'photo'   => null,
            'resume'  => null,
            'socials' => [],
        ];
        $oldCrewPhoto = $crew->photo;

        $crew = $this->service->processUpdate($data, $crew);

        // assert data
        $this->assertArraySubset(
            [
                'bio'   => 'new bio',
                'photo' => $oldCrewPhoto,
            ],
            $crew->toArray()
        );

        // assert storage
        Storage::assertExists($oldCrewPhoto);
    }

    /** @test */
    public function process_update_incomplete_socials()
    {
        Storage::fake();

        $crew     = $this->service->processCreate(
            $this->getProcessCreateData(),
            factory(User::class)->create()
        );
        $resume   = $crew->resumes->where('general', 1)->first();
        $oldFiles = [
            'photo'  => $crew->photo,
            'resume' => $resume->url,
        ];
        $data     = $this->getProcessUpdateData();

        $data['socials']['youtube']['url']          = null;
        $data['socials']['personal_website']['url'] = null;

        $crew = $this->service->processUpdate($data, $crew);

        $this->assertCount(7, $crew->social);
        $this->assertArraySubset(
            [
                [
                    'url'                 => 'https://www.facebook.com/new-castingcallsamerica/',
                    'social_link_type_id' => SocialLinkTypeID::FACEBOOK,
                ],
                [
                    'url'                 => 'https://twitter.com/new-casting_america',
                    'social_link_type_id' => SocialLinkTypeID::TWITTER,
                ],
                [
                    'url'                 => 'https://plus.google.com/+marvel-new',
                    'social_link_type_id' => SocialLinkTypeID::GOOGLE_PLUS,
                ],
                [
                    'url'                 => 'http://www.imdb.com/name/nm0000134/-updated',
                    'social_link_type_id' => SocialLinkTypeID::IMDB,
                ],
                [
                    'url'                 => 'http://new-updated.tumblr.com',
                    'social_link_type_id' => SocialLinkTypeID::TUMBLR,
                ],
                [
                    'url'                 => 'https://vimeo.com/new-mackevision',
                    'social_link_type_id' => SocialLinkTypeID::VIMEO,
                ],
                [
                    'url'                 => 'https://www.instagram.com/new-castingamerica/',
                    'social_link_type_id' => SocialLinkTypeID::INSTAGRAM,
                ],
            ],
            $crew->social->toArray()
        );
    }

    /** @test */
    public function update()
    {
        Storage::fake();

        $user      = factory(User::class)->create();
        $crew      = $this->service->create([
            'user_id'   => $user->id,
            'bio'       => 'some bio',
            'photo'     => UploadedFile::fake()->image('photo.png'),
            'photo_dir' => $user->uiid,
        ]);
        $data      = ['bio' => 'new bio'];
        $photoFile = UploadedFile::fake()->image('photo-new.png');
        $oldPhoto  = $crew->photo;


        $crew = $this->service->update($data, $photoFile, $crew);

        // assert data
        $this->assertArraySubset(
            [
                'bio'   => 'new bio',
                'photo' => 'photos/' . $user->uuid . '/' . $photoFile->hashName(),
            ],
            $crew->toArray()
        );

        // assert storage
        Storage::assertExists($crew->photo);
        Storage::assertMissing($oldPhoto);
    }

    /** @test */
    public function update_without_photo()
    {
        Storage::fake();

        $user      = factory(User::class)->create();
        $crew      = $this->service->create([
            'user_id'   => $user->id,
            'bio'       => 'some bio',
            'photo'     => UploadedFile::fake()->image('photo.png'),
            'photo_dir' => $user->uiid,
        ]);
        $data      = ['bio' => 'new bio'];
        $photoFile = null;
        $oldPhoto  = $crew->photo;

        $crew = $this->service->update($data, $photoFile, $crew);

        // assert data
        $this->assertArraySubset(
            [
                'bio'   => 'new bio',
                'photo' => $oldPhoto,
            ],
            $crew->toArray()
        );

        // assert storage
        Storage::assertExists($crew->photo);
    }

    /** @test */
    public function update_crew_general_resume()
    {
        Storage::fake();

        $user       = factory(User::class)->create();
        $crew       = $this->service->processCreate(
            [
                'bio'     => 'some bio',
                'photo'   => UploadedFile::fake()->image('photo.png'),
                'resume'  => UploadedFile::fake()->create('resume.pdf'),
                'socials' => [],
            ],
            $user
        );
        $resume     = $crew->resumes->where('general', 1)->first();
        $resumeFile = UploadedFile::fake()->create('new-resume.pdf');

        $this->service->updateGeneralResume($resumeFile, $crew);

        // assert that the old resume file does not exist anymore
        Storage::assertMissing($resume->url);

        // assert data
        $resume->refresh();

        $this->assertArraySubset(
            [
                'url'     => 'resumes/' . $user->uuid . '/' . $resumeFile->hashName(),
                'crew_id' => $crew->id,
                'general' => 1,
            ],
            $resume->toArray()
        );
        Storage::assertExists($resume->url);
    }

    /** @test */
    public function update_crew_general_resume_not_exists()
    {
        Storage::fake();

        $user = factory(User::class)->create();
        $crew = $this->service->create([
            'user_id'   => $user->id,
            'bio'       => 'some bio',
            'photo'     => UploadedFile::fake()->image('photo.png'),
            'photo_dir' => $user->uiid,
        ]);

        $resumeFile = UploadedFile::fake()->create('new-resume.pdf');

        $this->service->updateGeneralResume($resumeFile, $crew);

        $resume = $crew->resumes->where('general', 1)->first();

        $this->assertArraySubset(
            [
                'url'     => 'resumes/' . $user->uuid . '/' . $resumeFile->hashName(),
                'crew_id' => $crew->id,
                'general' => 1,
            ],
            $resume->toArray()
        );

        Storage::assertExists($resume->url);
    }

    /** @test */
    public function prepare_crew_data()
    {
        $data      = ['bio' => 'some bio'];
        $photoData = [
            'file' => UploadedFile::fake()->image('photo.png'),
            'dir'  => 'f5972b6f-5f55-49d2-8a79-e2c20cf39122',
        ];

        $result = $this->service->prepareCrewData($data, $photoData);

        $this->assertEquals(
            [
                'bio'   => 'some bio',
                'photo' => 'photos/f5972b6f-5f55-49d2-8a79-e2c20cf39122/' . $photoData['file']->hashName(),
            ],
            $result
        );
    }

    /** @test */
    public function prepare_crew_data_without_photo()
    {
        $data      = ['bio' => 'some bio'];
        $photoData = [
            'file' => null,
            'dir'  => '',
        ];

        $result = $this->service->prepareCrewData($data, $photoData);

        $this->assertEquals(
            ['bio' => 'some bio',],
            $result
        );
    }

    /** @test */
    public function prepare_crew_data_bio_is_null()
    {
        $data      = ['bio' => null];
        $photoData = [
            'file' => null,
            'dir'  => '',
        ];

        $result = $this->service->prepareCrewData($data, $photoData);

        $this->assertEquals(
            ['bio' => '',],
            $result
        );
    }

    /** @test */
    public function prepare_general_resume_data()
    {
        $resumeData = [
            'file' => UploadedFile::fake()->create('resume.pdf'),
            'dir'  => 'f5972b6f-5f55-49d2-8a79-e2c20cf39122',
        ];

        $this->assertEquals(
            [
                'url' => 'resumes/f5972b6f-5f55-49d2-8a79-e2c20cf39122/' . $resumeData['file']->hashName(),
            ],
            $this->service->prepareGeneralResumeData($resumeData)
        );
    }

    /** @test */
    public function update_socials()
    {
        Storage::fake();

        $user = factory(User::class)->create();
        $crew = $this->service->processCreate($this->getProcessCreateData(), $user);
        $data = $this->getProcessUpdateData()['socials'];

        $this->service->updateSocials($data, $crew);

        $this->assertCount(9, $crew->social);
        $this->assertArraySubset(
            [
                [
                    'url'                 => 'https://www.facebook.com/new-castingcallsamerica/',
                    'social_link_type_id' => SocialLinkTypeID::FACEBOOK,
                ],
                [
                    'url'                 => 'https://twitter.com/new-casting_america',
                    'social_link_type_id' => SocialLinkTypeID::TWITTER,
                ],
                [
                    'url'                 => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJwNEW',
                    'social_link_type_id' => SocialLinkTypeID::YOUTUBE,
                ],
                [
                    'url'                 => 'https://plus.google.com/+marvel-new',
                    'social_link_type_id' => SocialLinkTypeID::GOOGLE_PLUS,
                ],
                [
                    'url'                 => 'http://www.imdb.com/name/nm0000134/-updated',
                    'social_link_type_id' => SocialLinkTypeID::IMDB,
                ],
                [
                    'url'                 => 'http://new-updated.tumblr.com',
                    'social_link_type_id' => SocialLinkTypeID::TUMBLR,
                ],
                [
                    'url'                 => 'https://vimeo.com/new-mackevision',
                    'social_link_type_id' => SocialLinkTypeID::VIMEO,
                ],
                [
                    'url'                 => 'https://www.instagram.com/new-castingamerica/',
                    'social_link_type_id' => SocialLinkTypeID::INSTAGRAM,
                ],
                [
                    'url'                 => 'https://new-castingcallsamerica.com',
                    'social_link_type_id' => SocialLinkTypeID::PERSONAL_WEBSITE,
                ],
            ],
            $crew->social->toArray()
        );
    }

    /** @test */
    public function update_socials_incomplete()
    {
        Storage::fake();

        $user = factory(User::class)->create();
        $crew = $this->service->processCreate($this->getProcessCreateData(), $user);
        $data = $this->getProcessUpdateData()['socials'];

        $data['youtube']['url']          = null;
        $data['personal_website']['url'] = null;

        $this->service->updateSocials($data, $crew);

        $this->assertCount(7, $crew->social);
        $this->assertArraySubset(
            [
                [
                    'url'                 => 'https://www.facebook.com/new-castingcallsamerica/',
                    'social_link_type_id' => SocialLinkTypeID::FACEBOOK,
                ],
                [
                    'url'                 => 'https://twitter.com/new-casting_america',
                    'social_link_type_id' => SocialLinkTypeID::TWITTER,
                ],
                [
                    'url'                 => 'https://plus.google.com/+marvel-new',
                    'social_link_type_id' => SocialLinkTypeID::GOOGLE_PLUS,
                ],
                [
                    'url'                 => 'http://www.imdb.com/name/nm0000134/-updated',
                    'social_link_type_id' => SocialLinkTypeID::IMDB,
                ],
                [
                    'url'                 => 'http://new-updated.tumblr.com',
                    'social_link_type_id' => SocialLinkTypeID::TUMBLR,
                ],
                [
                    'url'                 => 'https://vimeo.com/new-mackevision',
                    'social_link_type_id' => SocialLinkTypeID::VIMEO,
                ],
                [
                    'url'                 => 'https://www.instagram.com/new-castingamerica/',
                    'social_link_type_id' => SocialLinkTypeID::INSTAGRAM,
                ],
            ],
            $crew->social->toArray()
        );
    }

    /**
     * @param array $customData
     *
     * @return array
     */
    public function getProcessCreateData($customData = [])
    {
        return array_merge([
            'bio'     => 'some bio',
            'photo'   => UploadedFile::fake()->image('photo.png'),
            'resume'  => UploadedFile::fake()->create('resume.pdf'),
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
                'google_plus'      => [
                    'url' => 'https://plus.google.com/+marvel',
                    'id'  => SocialLinkTypeID::GOOGLE_PLUS,
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
        ], $customData);
    }

    /**
     * @param array $customData
     *
     * @return array
     */
    public function getProcessUpdateData($customData = [])
    {
        return array_merge([
            'bio'     => 'updated bio',
            'photo'   => UploadedFile::fake()->image('new-photo.png'),
            'resume'  => UploadedFile::fake()->create('new-resume.pdf'),
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
                'google_plus'      => [
                    'url' => 'https://plus.google.com/+marvel-new',
                    'id'  => SocialLinkTypeID::GOOGLE_PLUS,
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
        ], $customData);
    }
}
