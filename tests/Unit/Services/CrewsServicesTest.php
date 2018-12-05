<?php

namespace Tests\Unit\Services;

use App\Models\Crew;
use App\Models\CrewReel;
use App\Models\CrewResume;
use App\Models\CrewSocial;
use App\Models\User;
use App\Services\CrewsServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

/**
 * @group CrewsServicesTest
 */
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

    /**
     * @test
     * @covers \App\Services\CrewsServices::processCreate
     */
    public function process_create()
    {
        Storage::fake();

        $user = factory(User::class)->create();
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

        $this->assertArraySubset(
            [
                'bio'   => 'some bio',
                'photo' => 'photos/' . $user->hash_id . '/' . $data['photo']->hashName(),
            ],
            $crew->toArray()
        );
        Storage::assertExists($crew->photo);

        // assert general resume
        $resume = $crew->resumes->where('general', 1)->first();

        $this->assertArraySubset(
            [
                'url'     => 'resumes/' . $user->hash_id . '/' . $data['resume']->hashName(),
                'crew_id' => $crew->id,
                'general' => 1,
            ],
            $resume->toArray()
        );

        Storage::assertExists($resume->url);

        // assert general reel has been created
        $reel = $crew->reels->where('general', 1)->first();

        $this->assertArraySubset(
            [
                'crew_id' => $crew->id,
                'url'     => 'https://www.youtube.com/embed/G8S81CEBdNs',
                'general' => 1,
            ],
            $reel->toArray()
        );

        // assert that the socials has been created
        $this->assertCount(9, $crew->socials);
        $this->assertArraySubset(
            [
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://www.facebook.com/castingcallsamerica/',
                    'social_link_type_id' => SocialLinkTypeID::FACEBOOK,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://twitter.com/casting_america',
                    'social_link_type_id' => SocialLinkTypeID::TWITTER,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJw',
                    'social_link_type_id' => SocialLinkTypeID::YOUTUBE,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://plus.google.com/+marvel',
                    'social_link_type_id' => SocialLinkTypeID::GOOGLE_PLUS,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'http://www.imdb.com/name/nm0000134/',
                    'social_link_type_id' => SocialLinkTypeID::IMDB,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'http://test.tumblr.com',
                    'social_link_type_id' => SocialLinkTypeID::TUMBLR,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://vimeo.com/mackevision',
                    'social_link_type_id' => SocialLinkTypeID::VIMEO,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://www.instagram.com/castingamerica/',
                    'social_link_type_id' => SocialLinkTypeID::INSTAGRAM,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://castingcallsamerica.com',
                    'social_link_type_id' => SocialLinkTypeID::PERSONAL_WEBSITE,
                ],
            ],
            $crew->socials->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Services\CrewsServices::create
     */
    public function create()
    {
        Storage::fake();

        $user      = factory(User::class)->create();
        $data      = ['bio' => 'some bio',];
        $photoFile = UploadedFile::fake()->image('photo.png');

        $crew = $this->service->create($data, $photoFile, $user);

        // assert data
        $this->assertArraySubset(
            [
                'bio'   => 'some bio',
                'photo' => 'photos/' . $user->hash_id . '/' . $photoFile->hashName(),
            ],
            $crew->toArray()
        );
        Storage::assertExists($crew->photo);
    }

    /**
     * @test
     * @covers 
     */
    public function create_general_resume()
    {
        Storage::fake();

        $crew       = factory(Crew::class)->create();
        $resumeFile = UploadedFile::fake()->create('resume.pdf');

        $this->service->createGeneralResume($resumeFile, $crew);

        // assert data
        $resume = $crew->resumes->where('general', 1)->first();

        $this->assertArraySubset(
            [
                'url'     => 'resumes/' . $crew->user->hash_id . '/' . $resumeFile->hashName(),
                'crew_id' => $crew->id,
                'general' => 1,
            ],
            $resume->toArray()
        );

        // assert file exists
        Storage::assertExists($resume->url);
    }

    /**
     * @test
     * @covers \App\Services\CrewsServices::createSocials
     */
    public function create_socials()
    {
        Storage::fake();

        $crew = factory(Crew::class)->create();
        $data = [
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
        ];

        $this->service->createSocials($data, $crew);

        $this->assertArraySubset(
            [
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://www.facebook.com/castingcallsamerica/',
                    'social_link_type_id' => SocialLinkTypeID::FACEBOOK,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://twitter.com/casting_america',
                    'social_link_type_id' => SocialLinkTypeID::TWITTER,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJw',
                    'social_link_type_id' => SocialLinkTypeID::YOUTUBE,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://plus.google.com/+marvel',
                    'social_link_type_id' => SocialLinkTypeID::GOOGLE_PLUS,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'http://www.imdb.com/name/nm0000134/',
                    'social_link_type_id' => SocialLinkTypeID::IMDB,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'http://test.tumblr.com',
                    'social_link_type_id' => SocialLinkTypeID::TUMBLR,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://vimeo.com/mackevision',
                    'social_link_type_id' => SocialLinkTypeID::VIMEO,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://www.instagram.com/castingamerica/',
                    'social_link_type_id' => SocialLinkTypeID::INSTAGRAM,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://castingcallsamerica.com',
                    'social_link_type_id' => SocialLinkTypeID::PERSONAL_WEBSITE,
                ],
            ],
            $crew->socials->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Services\CrewsServices::processUpdate
     */
    public function process_update()
    {
        Storage::fake();

        $crew   = factory(Crew::class)->states('PhotoUpload')->create();
        $resume = factory(CrewResume::class)->states('Upload')->create(['crew_id' => $crew->id]);
        $reel   = factory(CrewReel::class)->create(['crew_id' => $crew->id]);

        factory(CrewSocial::class, 9)->create(['crew_id' => $crew->id]);

        $oldFiles = [
            'photo'  => $crew->photo,
            'resume' => $resume->url,
        ];
        $data     = [
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
        ];

        $crew = $this->service->processUpdate($data, $crew);

        // assert crew
        $this->assertArraySubset(
            [
                'bio'   => 'updated bio',
                'photo' => 'photos/' . $crew->user->hash_id . '/' . $data['photo']->hashName(),
            ],
            $crew->toArray()
        );

        Storage::assertMissing($oldFiles['photo']);
        Storage::assertExists($crew->photo);

        // assert general resume
        $resume->refresh();

        $this->assertArraySubset(
            [
                'url'     => 'resumes/' . $crew->user->hash_id . '/' . $data['resume']->hashName(),
                'crew_id' => $crew->id,
                'general' => 1,
            ],
            $resume->toArray()
        );
        Storage::assertMissing($oldFiles['resume']);
        Storage::assertExists($resume->url);

        // assert socials
        $this->assertCount(9, $crew->socials);
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
            $crew->socials->toArray()
        );
    }

    /**
     * @test
     * @covers 
     */
    public function update()
    {
        Storage::fake();

        $crew      = factory(Crew::class)->states('PhotoUpload')->create();
        $data      = ['bio' => 'new bio'];
        $photoFile = UploadedFile::fake()->image('photo-new.png');
        $oldPhoto  = $crew->photo;

        $crew = $this->service->update($data, $photoFile, $crew);

        // assert data
        $this->assertArraySubset(
            [
                'bio'   => 'new bio',
                'photo' => 'photos/' . $crew->user->hash_id . '/' . $photoFile->hashName(),
            ],
            $crew->toArray()
        );

        // assert storage
        Storage::assertExists($crew->photo);
        Storage::assertMissing($oldPhoto);
    }

    /**
     * @test
     * @covers 
     */
    public function update_without_photo()
    {
        Storage::fake();

        $crew      = factory(Crew::class)->states('PhotoUpload')->create();
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
        Storage::assertExists($oldPhoto);
    }

    /**
     * @test
     * @covers 
     */
    public function update_crew_general_resume()
    {
        Storage::fake();

        $crew         = factory(Crew::class)->create();
        $resume       = factory(CrewResume::class)->states('Upload')->create(['crew_id' => $crew->id]);
        $oldResumeUrl = $resume->url;
        $resumeFile   = UploadedFile::fake()->create('new-resume.pdf');

        $this->service->updateGeneralResume($resumeFile, $crew);
        // assert data
        $resume->refresh();

        $this->assertArraySubset(
            [
                'url'     => 'resumes/' . $crew->user->hash_id . '/' . $resumeFile->hashName(),
                'crew_id' => $crew->id,
                'general' => 1,
            ],
            $resume->toArray()
        );
        Storage::assertMissing($oldResumeUrl);
        Storage::assertExists($resume->url);
    }

    /**
     * @test
     * @covers 
     */
    public function update_crew_general_resume_not_exists()
    {
        Storage::fake();

        $crew       = factory(Crew::class)->create();
        $resumeFile = UploadedFile::fake()->create('new-resume.pdf');

        $this->service->updateGeneralResume($resumeFile, $crew);

        $resume = $crew->resumes->where('general', 1)->first();

        $this->assertArraySubset(
            [
                'url'     => 'resumes/' . $crew->user->hash_id . '/' . $resumeFile->hashName(),
                'crew_id' => $crew->id,
                'general' => 1,
            ],
            $resume->toArray()
        );
        Storage::assertExists($resume->url);
    }

    /**
     * @test
     * @covers 
     */
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

    /**
     * @test
     * @covers 
     */
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

    /**
     * @test
     * @covers 
     */
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

    /**
     * @test
     */
    public function prepareGeneralReelData()
    {
        // youtube
        $this->assertEquals(
            ['url' => 'https://www.youtube.com/embed/G8S81CEBdNs'],
            $this->service->prepareGeneralReelData(['url' => 'https://www.youtube.com/embed/G8S81CEBdNs'])
        );
        $this->assertEquals(
            ['url' => 'https://www.youtube.com/embed/2-_rLbU6zJo'],
            $this->service->prepareGeneralReelData(['url' => 'https://www.youtube.com/watch?v=2-_rLbU6zJo'])
        );

        // vimeo
        $this->assertEquals(
            ['url' => 'https://player.vimeo.com/video/230046783'],
            $this->service->prepareGeneralReelData(['url' => 'https://vimeo.com/230046783'])
        );
        $this->assertEquals(
            ['url' => 'https://player.vimeo.com/video/230046783'],
            $this->service->prepareGeneralReelData(['url' => 'https://player.vimeo.com/video/230046783'])
        );
    }

    /**
     * @test
     * @covers 
     */
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

    /**
     * @test
     * @covers \App\Services\CrewsServices::updateSocials
     */
    public function update_socials()
    {
        Storage::fake();

        $crew = factory(Crew::class)->create();

        factory(CrewSocial::class, 9)->create(['crew_id' => $crew->id]);

        $data = [
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
        ];

        $this->service->updateSocials($data, $crew);

        $this->assertCount(9, $crew->socials);
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
            $crew->socials->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Services\CrewsServices::createGeneralReel
     */
    public function create_general_reel()
    {
        $crew = factory(Crew::class)->create();
        $data = [
            'url'     => 'http://www.youtube.com/embed/G8S81CEBdNs',
            'crew_id' => $crew->id,
        ];

        $this->service->createGeneralReel($data, $crew);

        // assert general reel data
        $reel = $crew->reels->where('general', 1)->first();

        $this->assertArraySubset(
            [
                'crew_id' => $data['crew_id'],
                'url'     => 'https://www.youtube.com/embed/G8S81CEBdNs',
                'general' => 1,
            ],
            $reel->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Services\CrewsServices::cleanReelUrl
     */
    public function clean_reel_url()
    {
        // youtube
        $this->assertEquals(
            'https://www.youtube.com/embed/G8S81CEBdNs',
            $this->service->cleanReelUrl('https://www.youtube.com/embed/G8S81CEBdNs')
        );
        $this->assertEquals(
            'https://www.youtube.com/embed/2-_rLbU6zJo',
            $this->service->cleanReelUrl('https://www.youtube.com/watch?v=2-_rLbU6zJo')
        );

        // vimeo
        $this->assertEquals(
            'https://player.vimeo.com/video/230046783',
            $this->service->cleanReelUrl('https://vimeo.com/230046783')
        );
        $this->assertEquals(
            'https://player.vimeo.com/video/230046783',
            $this->service->cleanReelUrl('https://player.vimeo.com/video/230046783')
        );
    }

    /**
     * @test
     * @covers \App\Services\CrewsServices::updateGeneralReel
     */
    public function update_general_reel()
    {
        $crew = factory(Crew::class)->create();
        $reel = factory(CrewReel::class)->create(['crew_id' => $crew->id]);
        $data = ['url' => 'https://www.youtube.com/embed/WI5AF1DCQlc'];

        $this->service->updateGeneralReel($data, $crew);

        // assert updated data
        $reel->refresh();

        $this->assertArraySubset(
            [
                'crew_id' => $crew->id,
                'url'     => 'https://www.youtube.com/embed/WI5AF1DCQlc',
                'general' => 1,
            ],
            $reel->toArray()
        );
    }

    /**
     * @test
     * @covers 
     */
    public function update_general_reel_not_exists()
    {
        $crew = factory(Crew::class)->create();
        $data = ['url' => 'https://www.youtube.com/embed/WI5AF1DCQlc'];

        $this->service->updateGeneralReel($data, $crew);

        // assert data
        $reel = $crew->reels->where('general', 1)->first();

        $this->assertArraySubset(
            [
                'crew_id' => $crew->id,
                'url'     => 'https://www.youtube.com/embed/WI5AF1DCQlc',
                'general' => 1,
            ],
            $reel->toArray()
        );
    }
}
