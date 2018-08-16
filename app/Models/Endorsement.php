<?php

namespace App\Models;

use App\EndorsementRequest;
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
        'id' => 'integer',
        'endorsement_request_id' => 'integer',
        'endorser_id' => 'integer',
        'approved_at' => 'datetime',
        'comment' => 'string',
        'deleted_at' => 'datetime',
    ];

    public function position()
    {
        return $this->request->crewPosition->position();
    }

    public function request()
    {
        return $this->belongsTo(EndorsementRequest::class, 'endorsement_request_id');
    }

    // TODO: create test,
    // NOTE: relations smell bad
    public function endorser()
    {
        return $this->belongsTo(Crew::class);
    }
}
