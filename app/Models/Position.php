<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
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
        'id'            => 'integer',
        'department_id' => 'integer',
        'has_gear'      => 'boolean',
        'has_union'     => 'boolean',
        'has_many'      => 'boolean'
    ];

}
