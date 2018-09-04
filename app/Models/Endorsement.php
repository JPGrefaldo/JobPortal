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
        'id' => 'integer',
        'endorsement_request_id' => 'integer',
        'endorser_id' => 'integer',
        'approved_at' => 'datetime',
        'comment' => 'string',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'endorsement_request_id',
        'endorser_id',
        'endorser_name',
        'endorser_email',
    ];

    public function position()
    {
        return $this->request->position();
    }

    public function request()
    {
        return $this->belongsTo(EndorsementRequest::class, 'endorsement_request_id');
    }

    public function endorser()
    {
        return $this->belongsTo(Crew::class, 'endorser_id');
    }
}
