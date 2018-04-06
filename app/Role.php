<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const PRODUCER = 'Producer';
    const CREW = 'Crew';
    const ADMIN = 'Admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
