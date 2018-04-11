<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Users many to many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positions()
    {
        return $this->hasMany(CrewPosition::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reels()
    {
        return $this->hasMany(CrewReel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function resumes()
    {
        return $this->hasMany(CrewResume::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gear()
    {
        return $this->hasMany(CrewGear::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function social()
    {
        return $this->hasMany(CrewSocial::class);
    }
}
