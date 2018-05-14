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
    public function createCrewUser($attributes = [])
    {
        $user = $this->createUser($attributes);

        UserRoles::create([
            'user_id' => $user->id,
            'role_id' => RoleId::CREW
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

        UserRoles::create([
            'user_id' => $user->id,
            'role_id' => RoleId::ADMIN
        ]);

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

        UserRoles::create([
            'user_id' => $user->id,
            'role_id' => RoleId::PRODUCER
        ]);

        return $user;
    }
}
