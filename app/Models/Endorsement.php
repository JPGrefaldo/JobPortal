<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endorsement extends Model
{
    use SoftDeletes;

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
        'id'                     => 'integer',
        'endorsement_request_id' => 'integer',
        'crew_position_id'       => 'integer',
        'approved_at'            => 'datetime',
        'deleted_at'             => 'datetime',
    ];


}
