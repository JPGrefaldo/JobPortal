<?php

namespace Tests\Support;

use App\Models\Role;
use App\Models\User;

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
}
