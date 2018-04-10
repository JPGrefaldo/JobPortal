<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserSites extends Pivot
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
    protected $table = 'user_sites';
}
