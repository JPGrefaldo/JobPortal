<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayType extends Model
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
        'id'       => 'integer',
        'name'     => 'string',
        'has_rate' => 'boolean',
    ];
}
