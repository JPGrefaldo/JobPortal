<?php

namespace Tests\Support;

use App\Models\Crew;
use App\Models\CrewReel;
use App\Models\CrewResume;
use App\Models\CrewSocial;
use App\Models\Role;
use App\Models\User;
use Arr;
use Illuminate\Http\UploadedFile;
use Storage;
use Tests\Support\Data\SocialLinkTypeID;

trait CreatesCrewModel
{
    /**
     * @param array $attributes
     * @return array
     */
    public function createCompleteCrew($attributes = [])
    {
        $attributes = $this->setupAttributes($attributes);

        $user = $this->createCrew($attributes);

        $resume = $this->createCrewResume(Arr::recursive_combine([
            'crew_id' => $user->crew->id,
        ], $attributes['resume']));

        $reel = $this->createCrewReel(Arr::recursive_combine([
            'crew_id' => $user->crew->id,
        ], $attributes['reel']));

        $socials = $this->createCrewSocials(Arr::recursive_combine([
            'crew_id' => $user->crew->id,
        ], $attributes['socials']));

        return [
            'user'    => $user,
            'crew'    => $user->crew,
            'resume'  => $resume,
            'reel'    => $reel,
            'socials' => $socials,
        ];
    }

    /**
     * @param array $attributes
     *
     * @return \App\Models\User
     */
    public function createCrew($attributes = [])
    {
        Storage::fake('s3');

        if (empty($attributes)) {
            $attributes = $this->setupAttributes($attributes);
        }

        $user = $this->createUser($attributes);

        $user->assignRole(Role::CREW);

        factory(Crew::class)->create(Arr::recursive_combine([
            'user_id'    => $user->id,
            'photo_path' => UploadedFile::fake()->create('fakephoto.jpg')->store(
                $user->hash_id . '/photos',
                's3',
                'public'
            ),
        ], $attributes['crew']));

        return $user;
    }

    /**
     * @param array $attributes
     * @return User
     */
    public function createUser($attributes = [])
    {
        return factory(User::class)->create($attributes['user']);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function createCrewResume($attributes = [])
    {
        return factory(CrewResume::class)->state('Upload')->create($attributes);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function createCrewReel($attributes = [])
    {
        return factory(CrewReel::class)->create($attributes);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function createCrewSocials($attributes = [])
    {
        return factory(CrewSocial::class)->create($attributes);
    }

    /**
     * @param array $customData
     *
     * @return array
     */
    public function getUpdateCrewData($customData = [])
    {
        $data = [
            'bio'          => 'updated bio',
            'photo'        => UploadedFile::fake()->image('new-photo.png'),
            'resume'       => UploadedFile::fake()->create('new-resume.pdf'),
            'reel_link'    => 'https://www.youtube.com/embed/WI5AF1DCQlc',
            'socials'      => [
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

        return Arr::recursive_combine($data, $customData);
    }

    /**
     * @param array $customData
     *
     * @return array
     */
    public function getCreateCrewData($customData = [])
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

        return Arr::recursive_combine($data, $customData);
    }

    /**
     * @param $attributes
     * @return array
     */
    private function setupAttributes($attributes)
    {
        $attributes = Arr::add($attributes, 'user', []);
        $attributes = Arr::add($attributes, 'crew', []);
        $attributes = Arr::add($attributes, 'reel', []);
        $attributes = Arr::add($attributes, 'resume', []);
        $attributes = Arr::add($attributes, 'socials', []);

        return $attributes;
    }
}
