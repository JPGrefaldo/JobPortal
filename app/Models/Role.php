<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const PRODUCER = 'Producer';
    const CREW = 'Crew';
    const ADMIN = 'Admin';

    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $casts = [
        'id'   => 'integer',
        'name' => 'string',
    ];

    /**
     * Users many to many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }

    /**
     * @param $name
     * @return int
     */
    public static function getRoleIdByName($name)
    {
        return Role::select(['id'])->whereName($name)->first()->id;
    }
}
