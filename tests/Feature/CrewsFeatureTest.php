<?php

namespace Tests\Feature;

use App\Models\Crew;
use App\Models\CrewReel;
use App\Models\CrewResume;
use App\Models\CrewSocial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

/**
 * @group CrewsFeatureTest
 */
class CrewsFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /** @test */
    public function create()
    {
        Storage::fake();

        $user = $this->createCrewUser();
        $data = $this->getCreateData();

        $response = $this->actingAs($user)
                         ->post('/crews', $data);

        // assert crew data
        $crew = Crew::where('user_id', $user->id)
                    ->first();

        $this->assertArraySubset(
            [
                'bio'   => 'some bio',
                'photo' => 'photos/' . $user->uuid . '/' . $data['photo']->hashName(),
            ],
            $crew->toArray()
        );
        Storage::assertExists($crew->photo);

        // assert general resume
        $resume = $crew->resumes->where('general', 1)
                                ->first();

        $this->assertArraySubset(
            [
                'url'     => 'resumes/' . $user->uuid . '/' . $data['resume']->hashName(),
                'crew_id' => $crew->id,
                'general' => 1,
            ],
            $resume->toArray()
        );

        Storage::assertExists($resume->url);

        // assert general reel has been created
        $reel = $crew->reels->where('general', 1)
                            ->first();

        $this->assertArraySubset(
            [
                'crew_id' => $crew->id,
                'url'     => 'https://www.youtube.com/embed/G8S81CEBdNs',
                'general' => 1,
            ],
            $reel->toArray()
        );

        // assert that the socials has been created
        $this->assertCount(9, $crew->social);
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
            $crew->social->toArray()
        );
    }

    /** @test */
    public function create_not_required()
    {
        Storage::fake();

        $user = $this->createCrewUser();
        $data = $this->getCreateData([
            'resume'                       => '',
            'reel'                         => '',
            'socials.facebook.url'         => '',
            'socials.twitter.url'          => '',
            'socials.youtube.url'          => '',
            'socials.google_plus.url'      => '',
            'socials.imdb.url'             => '',
            'socials.tumblr.url'           => '',
            'socials.vimeo.url'            => '',
            'socials.instagram.url'        => '',
            'socials.personal_website.url' => '',
        ]);

        $response = $this->actingAs($user)
                         ->post('/crews', $data);

        $response->assertSuccessful();

        // assert crew data
        $crew = Crew::where('user_id', $user->id)
                    ->first();

        $this->assertArraySubset(
            [
                'photo' => 'photos/' . $user->uuid . '/' . $data['photo']->hashName(),
            ],
            $crew->toArray()
        );
        Storage::assertExists($crew->photo);

        // assert that there are no resumes
        $this->assertCount(0, $crew->resumes);

        // assert that no reels has been created
        $this->assertCount(0, $crew->reels);

        // assert that no socials has been created
        $this->assertCount(0, $crew->social);
    }

    /** @test */
    public function create_invalid_data()
    {
        Storage::fake();

        $user = $this->createCrewUser();
        $data = $this->getCreateData([
            'photo'                        => UploadedFile::fake()
                                                          ->create('image.php'),
            'resume'                       => UploadedFile::fake()
                                                          ->create('resume.php'),
            'reel'                         => 'https://some-invalid-reel.com',
            'socials.facebook.url'         => 'https://invalid-facebook.com/invalid',
            'socials.facebook.id'          => '',
            'socials.twitter.url'          => 'https://invalid-twitter.com/invalid',
            'socials.youtube.url'          => 'https://invalid-youtube.com/invalid',
            'socials.google_plus.url'      => 'https://invalid-gplus.com/invalid',
            'socials.imdb.url'             => 'https://invalid-imdb.com/invalid',
            'socials.tumblr.url'           => 'https://invalid-tumblr.test/invalid',
            'socials.vimeo.url'            => 'https://invalid-vimeo.com/invalid',
            'socials.instagram.url'        => 'https://invalid-instagram.com/invalid',
            'socials.personal_website.url' => 'http://mysite.test',
        ]);

        $response = $this->actingAs($user)
                         ->post('/crews', $data);

        $response->assertSessionHasErrors(
            [
                'photo'                        => 'The photo must be an image.',
                'resume'                       => 'The resume must be a file of type: pdf, doc, docx.',
                'reel'                         => 'The reel must be a valid Reel.',
                'socials.facebook.url'         => 'facebook must be a valid Facebook URL.',
                'socials.twitter.url'          => 'twitter must be a valid Twitter URL.',
                'socials.youtube.url'          => 'youtube must be a valid YouTube URL.',
                'socials.google_plus.url'      => 'google plus must be a valid Google Plus URL.',
                'socials.imdb.url'             => 'imdb must be a valid IMDB URL.',
                'socials.tumblr.url'           => 'tumblr must be a valid Tumblr URL.',
                'socials.vimeo.url'            => 'vimeo must be a valid Vimeo URL.',
                'socials.instagram.url'        => 'instagram must be a valid Instagram URL.',
                'socials.personal_website.url' => 'The personal website is invalid.',
            ]
        );
    }

    /** @test */
    public function create_youtube_cleaned()
    {
        Storage::fake();

        $user = $this->createCrewUser();
        $data = $this->getCreateData([
            'reel'                => 'https://www.youtube.com/watch?v=2-_rLbU6zJo',
            'socials.youtube.url' => 'https://www.youtube.com/watch?v=G8S81CEBdNs',
        ]);

        $response = $this->actingAs($user)
                         ->post('/crews', $data);

        // assert general reel has been cleaned
        $crew = Crew::where('user_id', $user->id)
                    ->first();
        $reel = $crew->reels->where('general', 1)
                            ->first();

        $this->assertArraySubset(
            [
                'crew_id' => $crew->id,
                'url'     => 'https://www.youtube.com/embed/2-_rLbU6zJo',
                'general' => 1,
            ],
            $reel->toArray()
        );

        // assert youtube social has been cleaned
        $social = $crew->social()
                       ->where('social_link_type_id', SocialLinkTypeID::YOUTUBE)
                       ->first();

        $this->assertArraySubset(
            [
                'crew_id'             => $crew->id,
                'url'                 => 'https://www.youtube.com/embed/G8S81CEBdNs',
                'social_link_type_id' => SocialLinkTypeID::YOUTUBE,
            ],
            $social->toArray()
        );
    }

    /** @test */
    public function create_vimeo_reel_cleaned()
    {
        Storage::fake();

        $user = $this->createCrewUser();
        $data = $this->getCreateData(['reel' => 'https://vimeo.com/230046783']);

        $response = $this->actingAs($user)
                         ->post('/crews', $data);

        // assert general reel has been created
        $crew = Crew::where('user_id', $user->id)
                    ->first();
        $reel = $crew->reels->where('general', 1)
                            ->first();

        $this->assertArraySubset(
            [
                'crew_id' => $crew->id,
                'url'     => 'https://player.vimeo.com/video/230046783',
                'general' => 1,
            ],
            $reel->toArray()
        );
    }

    /** @test */
    public function create_unauthorized()
    {
        $user = factory(User::class)->create();
        $data = $this->getCreateData();

        $response = $this->actingAs($user)
                         ->post('/crews', $data);

        $response->assertRedirect('login');
        $this->assertGuest();
    }

    /** @test */
    public function update()
    {
        Storage::fake();

        $user   = $this->createCrewUser();
        $crew   = factory(Crew::class)
            ->states('PhotoUpload')
            ->create(['user_id' => $user->id]);
        $resume = factory(CrewResume::class)
            ->states('Upload')
            ->create(['crew_id' => $crew->id]);
        $reel   = factory(CrewReel::class)->create(['crew_id' => $crew->id]);

        factory(CrewSocial::class, 9)->create(['crew_id' => $crew->id]);

        $oldFiles = [
            'photo'  => $crew->photo,
            'resume' => $resume->url,
        ];
        $data     = $this->getUpdateData();

        $response = $this->actingAs($user)
                         ->put('/crews/' . $crew->id, $data);

        // assert crew data
        $crew->refresh();

        $this->assertArraySubset(
            [
                'bio'   => 'updated bio',
                'photo' => 'photos/' . $user->uuid . '/' . $data['photo']->hashName(),
            ],
            $crew->toArray()
        );
        Storage::assertMissing($oldFiles['photo']);
        Storage::assertExists($crew->photo);

        // assert general resume
        $resume->refresh();

        $this->assertArraySubset(
            [
                'url'     => 'resumes/' . $user->uuid . '/' . $data['resume']->hashName(),
                'crew_id' => $crew->id,
                'general' => 1,
            ],
            $resume->toArray()
        );
        Storage::assertMissing($oldFiles['resume']);
        Storage::assertExists($resume->url);

        // assert reel
        $reel->refresh();

        $this->assertArraySubset(
            [
                'crew_id' => $crew->id,
                'url'     => 'https://www.youtube.com/embed/WI5AF1DCQlc',
                'general' => 1,
            ],
            $reel->toArray()
        );

        // assert socials
        $this->assertCount(9, $crew->social);
        $this->assertArraySubset(
            [
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://www.facebook.com/new-castingcallsamerica/',
                    'social_link_type_id' => SocialLinkTypeID::FACEBOOK,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://twitter.com/new-casting_america',
                    'social_link_type_id' => SocialLinkTypeID::TWITTER,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJwNEW',
                    'social_link_type_id' => SocialLinkTypeID::YOUTUBE,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://plus.google.com/+marvel-new',
                    'social_link_type_id' => SocialLinkTypeID::GOOGLE_PLUS,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'http://www.imdb.com/name/nm0000134/-updated',
                    'social_link_type_id' => SocialLinkTypeID::IMDB,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'http://new-updated.tumblr.com',
                    'social_link_type_id' => SocialLinkTypeID::TUMBLR,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://vimeo.com/new-mackevision',
                    'social_link_type_id' => SocialLinkTypeID::VIMEO,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://www.instagram.com/new-castingamerica/',
                    'social_link_type_id' => SocialLinkTypeID::INSTAGRAM,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://new-castingcallsamerica.com',
                    'social_link_type_id' => SocialLinkTypeID::PERSONAL_WEBSITE,
                ],
            ],
            $crew->social->toArray()
        );
    }

    /** @test */
    public function update_no_relations()
    {
        Storage::fake();

        $user = $this->createCrewUser();
        $crew = factory(Crew::class)->create(['user_id' => $user->id]);
        $data = $this->getUpdateData();

        $response = $this->actingAs($user)
                         ->put('/crews/' . $crew->id, $data);

        // assert general resume
        $resume = $crew->resumes->where('general', 1)
                                ->first();

        $this->assertArraySubset(
            [
                'url'     => 'resumes/' . $user->uuid . '/' . $data['resume']->hashName(),
                'crew_id' => $crew->id,
                'general' => 1,
            ],
            $resume->toArray()
        );
        Storage::assertExists($resume->url);

        // assert general reel
        $reel = $crew->reels->where('general', 1)
                            ->first();

        $this->assertArraySubset(
            [
                'crew_id' => $crew->id,
                'url'     => 'https://www.youtube.com/embed/WI5AF1DCQlc',
                'general' => 1,
            ],
            $reel->toArray()
        );

        //  assert socials
        $this->assertCount(9, $crew->social);
        $this->assertArraySubset(
            [
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://www.facebook.com/new-castingcallsamerica/',
                    'social_link_type_id' => SocialLinkTypeID::FACEBOOK,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://twitter.com/new-casting_america',
                    'social_link_type_id' => SocialLinkTypeID::TWITTER,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJwNEW',
                    'social_link_type_id' => SocialLinkTypeID::YOUTUBE,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://plus.google.com/+marvel-new',
                    'social_link_type_id' => SocialLinkTypeID::GOOGLE_PLUS,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'http://www.imdb.com/name/nm0000134/-updated',
                    'social_link_type_id' => SocialLinkTypeID::IMDB,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'http://new-updated.tumblr.com',
                    'social_link_type_id' => SocialLinkTypeID::TUMBLR,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://vimeo.com/new-mackevision',
                    'social_link_type_id' => SocialLinkTypeID::VIMEO,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://www.instagram.com/new-castingamerica/',
                    'social_link_type_id' => SocialLinkTypeID::INSTAGRAM,
                ],
                [
                    'crew_id'             => $crew->id,
                    'url'                 => 'https://new-castingcallsamerica.com',
                    'social_link_type_id' => SocialLinkTypeID::PERSONAL_WEBSITE,
                ],
            ],
            $crew->social->toArray()
        );
    }

    /** @test */
    public function update_without_photo()
    {
        Storage::fake();

        $user         = $this->createCrewUser();
        $crew         = factory(Crew::class)
            ->states('PhotoUpload')
            ->create(['user_id' => $user->id]);
        $oldCrewPhoto = $crew->photo;
        $data         = $data = $this->getUpdateData(['photo' => '']);

        $response = $this->actingAs($user)
                         ->put('/crews/' . $crew->id, $data);

        $response->assertSuccessful();

        $crew->refresh();

        $this->assertArraySubset(
            [
                'bio'   => 'updated bio',
                'photo' => $oldCrewPhoto,
            ],
            $crew->toArray()
        );
        Storage::assertExists($oldCrewPhoto);
    }

    /** @test */
    public function update_incomplete_socials()
    {
        Storage::fake();

        $user = $this->createCrewUser();
        $crew = factory(Crew::class)->create(['user_id' => $user->id]);
        $data = $this->getUpdateData([
            'socials.youtube.url'          => '',
            'socials.personal_website.url' => '',
        ]);

        $response = $this->actingAs($user)
                         ->put('/crews/' . $crew->id, $data);

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
    public function update_youtube_cleaned()
    {
        Storage::fake();

        $user = $this->createCrewUser();
        $crew = factory(Crew::class)->create(['user_id' => $user->id]);
        $reel = factory(CrewReel::class)->create(['crew_id' => $crew->id]);

        $data = $this->getUpdateData([
            'reel'                => 'https://www.youtube.com/watch?v=2-_rLbU6zJo',
            'socials.youtube.url' => 'https://www.youtube.com/watch?v=G8S81CEBdNs',
        ]);

        $response = $this->actingAs($user)
                         ->put('/crews/' . $crew->id, $data);

        // assert general reel has been cleaned
        $reel->refresh();

        $this->assertArraySubset(
            [
                'crew_id' => $crew->id,
                'url'     => 'https://www.youtube.com/embed/2-_rLbU6zJo',
                'general' => 1,
            ],
            $reel->toArray()
        );

        // assert youtube social has been cleaned
        $social = $crew->social()
                       ->where('social_link_type_id', SocialLinkTypeID::YOUTUBE)
                       ->first();

        $this->assertArraySubset(
            [
                'crew_id'             => $crew->id,
                'url'                 => 'https://www.youtube.com/embed/G8S81CEBdNs',
                'social_link_type_id' => SocialLinkTypeID::YOUTUBE,
            ],
            $social->toArray()
        );
    }

    /** @test */
    public function update_vimeo_reel_cleaned()
    {
        Storage::fake();

        $user = $this->createCrewUser();
        $crew = factory(Crew::class)->create(['user_id' => $user->id]);
        $reel = factory(CrewReel::class)->create(['crew_id' => $crew->id]);
        $data = $this->getUpdateData(['reel' => 'https://vimeo.com/230046783']);

        $response = $this->actingAs($user)
                         ->put('/crews/' . $crew->id, $data);

        // assert general reel has been created
        $reel->refresh();

        $this->assertArraySubset(
            [
                'crew_id' => $crew->id,
                'url'     => 'https://player.vimeo.com/video/230046783',
                'general' => 1,
            ],
            $reel->toArray()
        );
    }

    /** @test */
    public function update_invalid_data()
    {
        Storage::fake();

        $user = $this->createCrewUser();
        $crew = factory(Crew::class)->create(['user_id' => $user->id]);
        $data = $this->getUpdateData([
            'photo'                        => UploadedFile::fake()
                                                          ->create('image.php'),
            'resume'                       => UploadedFile::fake()
                                                          ->create('resume.php'),
            'reel'                         => 'https://some-invalid-reel.com',
            'socials.facebook.url'         => 'https://invalid-facebook.com/invalid',
            'socials.facebook.id'          => '',
            'socials.twitter.url'          => 'https://invalid-twitter.com/invalid',
            'socials.youtube.url'          => 'https://invalid-youtube.com/invalid',
            'socials.google_plus.url'      => 'https://invalid-gplus.com/invalid',
            'socials.imdb.url'             => 'https://invalid-imdb.com/invalid',
            'socials.tumblr.url'           => 'https://invalid-tumblr.test/invalid',
            'socials.vimeo.url'            => 'https://invalid-vimeo.com/invalid',
            'socials.instagram.url'        => 'https://invalid-instagram.com/invalid',
            'socials.personal_website.url' => 'http://mysite.test',
        ]);

        $response = $this->actingAs($user)
                         ->put('/crews/' . $crew->id, $data);

        $response->assertSessionHasErrors(
            [
                'photo'                        => 'The photo must be an image.',
                'resume'                       => 'The resume must be a file of type: pdf, doc, docx.',
                'reel'                         => 'The reel must be a valid Reel.',
                'socials.facebook.url'         => 'facebook must be a valid Facebook URL.',
                'socials.twitter.url'          => 'twitter must be a valid Twitter URL.',
                'socials.youtube.url'          => 'youtube must be a valid YouTube URL.',
                'socials.google_plus.url'      => 'google plus must be a valid Google Plus URL.',
                'socials.imdb.url'             => 'imdb must be a valid IMDB URL.',
                'socials.tumblr.url'           => 'tumblr must be a valid Tumblr URL.',
                'socials.vimeo.url'            => 'vimeo must be a valid Vimeo URL.',
                'socials.instagram.url'        => 'instagram must be a valid Instagram URL.',
                'socials.personal_website.url' => 'The personal website is invalid.',
            ]
        );
    }

    /** @test */
    public function update_not_exists()
    {
        Storage::fake();

        $user = $this->createCrewUser();
        $data = $this->getUpdateData();

        $response = $this->actingAs($user)
                         ->put('/crews/5', $data);

        $response->assertStatus(404);
    }

    /** @test */
    public function update_unauthorized()
    {
        $crew = factory(Crew::class)->create();
        $data = $this->getUpdateData();

        $response = $this->actingAs($crew->user)
                         ->put('/crews/' . $crew->id, $data);

        $response->assertRedirect('login');
        $this->assertGuest();
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
            'photo'   => UploadedFile::fake()
                                     ->image('photo.png'),
            'resume'  => UploadedFile::fake()
                                     ->create('resume.pdf'),
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

        return $this->customizeData($data, $customData);
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
            'photo'   => UploadedFile::fake()
                                     ->image('new-photo.png'),
            'resume'  => UploadedFile::fake()
                                     ->create('new-resume.pdf'),
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
}
