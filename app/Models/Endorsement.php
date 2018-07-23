<?php

namespace App\Models;

use App\Models\CrewPosition;
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
        'endorser_id'            => 'integer',
        'approved_at'            => 'datetime',
        'comment'                => 'string',
        'deleted_at'             => 'datetime',
    ];

    public function crewPosition()
    {
        // return $this->belongsTo(CrewPosition::class);
    }

    public function position()
    {
        // return $this->crewPosition->position();
    }
}
