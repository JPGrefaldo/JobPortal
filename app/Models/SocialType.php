<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialType extends Model
{
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
        'id'      => 'integer',
    ];
}
