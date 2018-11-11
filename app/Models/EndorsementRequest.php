<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EndorsementRequest extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $casts = [
        'id'             => 'integer',
        'endorsement_id' => 'integer',
        'token'          => 'string',
        'message'        => 'string',
    ];


}
