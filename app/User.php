<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'confirmation_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Roles many to many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }


    public function sites()
    {
        return $this->belongsToMany(Site::class, 'user_sites');
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasRole($name)
    {
        return $this->roles()->get()
            ->contains('name', $name);
    }

    /**
     * @param string $hostname
     *
     * @return bool
     */
    public function hasSite($hostname)
    {
        return $this->sites()->get()
            ->contains('hostname', $hostname);
    }
}
