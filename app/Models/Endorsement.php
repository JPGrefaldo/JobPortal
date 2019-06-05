<?php

namespace App\Models;

use App\Events\CreateEndorsement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    protected $dispatchesEvents = [
        "created" => CreateEndorsement::class,
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id'                     => 'integer',
        'crew_position_id'       => 'integer',
        'endorsement_request_id' => 'integer',
        'approved_at'            => 'datetime',
        'deleted_at'             => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function request()
    {
        return $this->belongsTo(EndorsementRequest::class, 'endorsement_request_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function crewPosition()
    {
        return $this->hasOne(CrewPosition::class, 'id', 'crew_position_id');
    }

    /**
     * @return mixed
     */
    public function endorser()
    {
        return $this->hasOneThrough(
            EndorsementEndorser::class,
            EndorsementRequest::class,
            'endorsement_endorser_id',
            'id'
        );
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_at');
    }
}
