<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endorsement extends Model
{
    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id'               => 'integer',
        'crew_position_id' => 'integer',
        'endorser_email'   => 'string',
        'approved_at'      => 'datetime',
        'comment'          => 'string',
        'deleted'          => 'boolean',
    ];
}
