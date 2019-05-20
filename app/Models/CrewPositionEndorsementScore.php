<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrewPositionEndorsementScore extends Model
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
        'id'                => 'integer',
        'crew_position_id'  => 'integer',
        'score'             => 'integer',
    ];
}
