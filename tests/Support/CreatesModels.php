<?php

namespace Tests\Support;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use App\Utils\StrUtils;
use Carbon\Carbon;

trait CreatesModels
{
    /**
     * @param array $attributes
     *
     * @return \App\Models\User
     */
    public function createUser($attributes = [])
    {
        return factory(User::class)->create($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return \App\Models\User
     */
    public function createCrew($attributes = [])
    {
        $user = $this->createUser($attributes);

        $user->assignRole(Role::CREW);

        factory(Crew::class)->create([
            'user_id' => $user->id,
        ]);

        return $user;
    }

    /**
     * @param array $attributes
     *
     * @return \App\Models\User
     */
    public function createAdmin($attributes = [])
    {
        $user = $this->createUser($attributes);

        $user->assignRole(Role::ADMIN);

        return $user;
    }

    /**
     * @param array $attributes
     *
     * @return \App\Models\User
     */
    public function createProducer($attributes = [])
    {
        $user = $this->createUser($attributes);

        $user->assignRole(Role::PRODUCER);

        return $user;
    }

    /**
     * @return Position
     */
    public function getRandomPosition(): Position
    {
        return Position::inRandomOrder()->get()->first();
    }
}
