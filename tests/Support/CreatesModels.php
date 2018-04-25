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
     * @return mixed
     */
    public function createUser($attributes = [])
    {
        return factory(User::class)->create($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return mixed
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
}