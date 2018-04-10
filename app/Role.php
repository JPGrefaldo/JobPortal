<?php

namespace App;

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
     * Users many to many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }
}