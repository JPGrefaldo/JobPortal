<?php


namespace Tests\Support;


use App\Models\User;
use App\Models\UserRoles;
use Tests\Support\Data\RoleId;

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
        return factory(User::class)
            ->states('withCrewRole')
            ->create($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return \App\Models\User
     */
    public function createAdmin($attributes = [])
    {
        return factory(User::class)
            ->states('withAdminRole')
            ->create($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return \App\Models\User
     */
    public function createProducer($attributes = [])
    {
        return factory(User::class)
            ->states('withProducerRole')
            ->create($attributes);
    }
}
