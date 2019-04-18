<?php

namespace Tests\Support;

use App\Models\Crew;
use App\Models\CrewReel;
use App\Models\CrewResume;
use App\Models\CrewSocial;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Storage;

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

        $resume = $this->createCrewResume(array_merge([
            'crew_id' => $user->crew->id,
        ], $attributes['resume']));

        $reel = $this->createCrewReel(array_merge([
            'crew_id' => $user->crew->id,
        ], $attributes['reel']));

        $socials = $this->createCrewSocials(array_merge([
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

        $user = $this->createUser($attributes);

        $user->assignRole(Role::CREW);

        factory(Crew::class)->create(array_merge([
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


    private function setupAttributes($attributes)
    {
        $attributes = \Arr::add($attributes, 'user', []);
        $attributes = \Arr::add($attributes, 'crew', []);
        $attributes = \Arr::add($attributes, 'reel', []);
        $attributes = \Arr::add($attributes, 'resume', []);
        $attributes = \Arr::add($attributes, 'socials', []);

        return $attributes;
    }
}
