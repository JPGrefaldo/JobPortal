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
        'id'             => 'integer',
        'project_job_id' => 'integer',
        'endorser_id'    => 'integer',
        'endorsee_id'    => 'integer',
    ];
}
