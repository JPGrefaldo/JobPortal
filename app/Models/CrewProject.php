<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrewProject extends Pivot
{
    use SoftDeletes;

    /**
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var array
     */
    protected $casts = [
        'id'         => 'integer',
        'crew_id'    => 'integer',
        'project_id' => 'project_id',
    ];
}
