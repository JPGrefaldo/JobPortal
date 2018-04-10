<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRoles extends Pivot
{
    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'user_roles';
}
