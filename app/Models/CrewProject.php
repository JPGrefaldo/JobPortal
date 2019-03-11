<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrewProject extends Pivot
{
    use SoftDeletes;

    protected $casts = [
        'id'         => 'integer',
        'crew_id'    => 'integer',
        'project_id' => 'project_id',
    ];
}
