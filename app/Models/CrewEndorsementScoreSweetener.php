<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrewEndorsementScoreSweetener extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $casts = [
        'id'        => 'integer',
        'crew_id'   => 'integer',
        'sweetener' => 'integer',
    ];
}
