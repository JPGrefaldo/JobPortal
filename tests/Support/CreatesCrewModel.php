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

        $resume = $this->createCrewResume(array_merge_recursive($attributes['resume'], [
            'crew_id' => $user->crew->id,
        ]));

        $reel = $this->createCrewReel(array_merge_recursive($attributes['reel'], [
            'crew_id' => $user->crew->id,
        ]));

        $socials = $this->createCrewSocials(array_merge_recursive($attributes['socials'], [
            'crew_id' => $user->crew->id,
        ]));

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

        /*dd(array_merge_recursive($attributes['crew'], [
            'user_id'    => $user->id,
            'photo_path' => UploadedFile::fake()->create('fakephoto.jpg'),
        ]));*/

        factory(Crew::class)->create(array_merge_recursive($attributes['crew'], [
            'user_id'    => $user->id,
            //'photo_path' => UploadedFile::fake()->create('fakephoto.jpg'),
        ]));

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
        return factory(CrewResume::class)->create($attributes);
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
